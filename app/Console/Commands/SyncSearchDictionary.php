<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Shop\Entities\Product;
use Modules\Shop\Services\SearchDictionaryService;

class SyncSearchDictionary extends Command
{
    protected $signature = 'shop:sync-search-dictionary';

    protected $description = 'Isi kamus pencarian dari nama produk yang sudah ada';

    public function handle(SearchDictionaryService $dictionaryService): int
    {
        $count = 0;

        Product::query()
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->orderBy('id')
            ->chunk(100, function ($products) use ($dictionaryService, &$count) {
                foreach ($products as $product) {
                    $dictionaryService->syncFromText($product->name);
                    $count++;
                }
            });

        $this->info("Kamus pencarian diperbarui dari {$count} produk.");

        return self::SUCCESS;
    }
}
