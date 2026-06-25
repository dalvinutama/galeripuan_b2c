<?php

namespace Modules\Shop\Services;

use Modules\Shop\Entities\SearchDictionary;

class SearchDictionaryService
{
    private const MIN_WORD_LENGTH = 3;

    private const MAX_LEVENSHTEIN_DISTANCE = 2;

    /**
     * Pecah teks menjadi kata-kata unik untuk kamus pencarian.
     *
     * @return array<int, string>
     */
    public function tokenize(string $text): array
    {
        $text = mb_strtolower(trim($text));
        $parts = preg_split('/[^a-z0-9]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);

        if ($parts === false) {
            return [];
        }

        $words = [];

        foreach ($parts as $part) {
            if (mb_strlen($part) >= self::MIN_WORD_LENGTH) {
                $words[] = $part;
            }
        }

        return array_values(array_unique($words));
    }

    /**
     * Simpan kata-kata baru ke kamus (abaikan duplikat).
     *
     * @param  array<int, string>  $words
     */
    public function syncWords(array $words): void
    {
        foreach ($words as $word) {
            SearchDictionary::firstOrCreate(['word' => $word]);
        }
    }

    public function syncFromText(string $text): void
    {
        $this->syncWords($this->tokenize($text));
    }

    /**
     * Cari kata terdekat di kamus menggunakan Levenshtein Distance.
     */
    public function findClosestWord(string $input): ?string
    {
        $input = mb_strtolower(trim($input));

        if (mb_strlen($input) < self::MIN_WORD_LENGTH) {
            return null;
        }

        if (SearchDictionary::where('word', $input)->exists()) {
            return $input;
        }

        $inputLength = mb_strlen($input);
        $candidates = SearchDictionary::query()
            ->whereRaw('ABS(CHAR_LENGTH(word) - ?) <= ?', [$inputLength, self::MAX_LEVENSHTEIN_DISTANCE])
            ->pluck('word');

        $bestWord = null;
        $bestDistance = PHP_INT_MAX;

        foreach ($candidates as $word) {
            $distance = levenshtein($input, $word);

            if ($distance < $bestDistance) {
                $bestDistance = $distance;
                $bestWord = $word;
            }
        }

        if ($bestWord !== null && $bestDistance <= self::MAX_LEVENSHTEIN_DISTANCE) {
            return $bestWord;
        }

        return null;
    }

    /**
     * Koreksi ejaan setiap kata dalam frase pencarian.
     */
    public function correctKeyword(string $keyword): string
    {
        $words = $this->tokenize($keyword);

        if ($words === []) {
            return trim(mb_strtolower($keyword));
        }

        $corrected = [];

        foreach ($words as $word) {
            $corrected[] = $this->findClosestWord($word) ?? $word;
        }

        return implode(' ', $corrected);
    }
}
