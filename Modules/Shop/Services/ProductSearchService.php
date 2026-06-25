<?php

namespace Modules\Shop\Services;

use Illuminate\Database\Eloquent\Builder;

class ProductSearchService
{
    public function __construct(
        private SearchDictionaryService $dictionaryService
    ) {}

    /**
     * Terapkan pencarian hybrid: Full-Text Search → Levenshtein → LIKE fallback.
     */
    public function applySearch(Builder $query, string $keyword): Builder
    {
        $keyword = trim($keyword);

        if ($keyword === '') {
            return $query;
        }

        $fullTextQuery = $this->formatFullTextQuery($keyword);

        if ($this->hasFullTextResults($query, $fullTextQuery)) {
            return $query->whereFullText(['name', 'excerpt'], $fullTextQuery, ['mode' => 'boolean']);
        }

        $correctedKeyword = $this->dictionaryService->correctKeyword($keyword);

        if ($correctedKeyword !== mb_strtolower($keyword)) {
            $correctedFullTextQuery = $this->formatFullTextQuery($correctedKeyword);

            if ($this->hasFullTextResults($query, $correctedFullTextQuery)) {
                return $query->whereFullText(['name', 'excerpt'], $correctedFullTextQuery, ['mode' => 'boolean']);
            }
        }

        $likeTerm = $correctedKeyword ?: $keyword;

        return $query->where(function (Builder $builder) use ($likeTerm) {
            $builder->where('name', 'LIKE', "%{$likeTerm}%")
                ->orWhere('excerpt', 'LIKE', "%{$likeTerm}%");
        });
    }

    /**
     * Urutkan hasil pencarian berdasarkan relevansi FTS.
     */
    public function applyRelevanceOrder(Builder $query, string $keyword): Builder
    {
        $keyword = trim($keyword);

        if ($keyword === '') {
            return $query;
        }

        $fullTextQuery = $this->formatFullTextQuery(
            $this->dictionaryService->correctKeyword($keyword)
        );

        return $query->orderByRaw(
            'MATCH(name, excerpt) AGAINST(? IN BOOLEAN MODE) DESC',
            [$fullTextQuery]
        );
    }

    private function hasFullTextResults(Builder $query, string $fullTextQuery): bool
    {
        return (clone $query)
            ->whereFullText(['name', 'excerpt'], $fullTextQuery, ['mode' => 'boolean'])
            ->limit(1)
            ->exists();
    }

    private function formatFullTextQuery(string $keyword): string
    {
        $words = $this->dictionaryService->tokenize($keyword);

        if ($words === []) {
            return '+' . preg_replace('/[^\p{L}\p{N}]+/u', '', mb_strtolower($keyword)) . '*';
        }

        return collect($words)
            ->map(fn (string $word) => '+' . $word . '*')
            ->implode(' ');
    }
}
