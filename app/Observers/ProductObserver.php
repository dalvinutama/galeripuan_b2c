<?php

namespace App\Observers;

use Modules\Shop\Entities\Product;
use Modules\Shop\Services\SearchDictionaryService;

class ProductObserver
{
    public function __construct(
        private SearchDictionaryService $dictionaryService
    ) {}

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        if ($product->name) {
            $this->dictionaryService->syncFromText($product->name);
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        if ($product->isDirty('name') && $product->name) {
            $this->dictionaryService->syncFromText($product->name);
        }

        if ($product->isDirty('sale_price')) {
            $newSalePrice = $product->sale_price;
            $oldSalePrice = $product->getOriginal('sale_price');
            $originalPrice = $product->getOriginal('price');

            // Jika sale_price baru lebih murah dari sale_price lama, ATAU
            // Jika sebelumnya tidak ada sale_price, dan sale_price baru lebih murah dari harga normal
            if ($newSalePrice > 0 && 
                (($oldSalePrice && $newSalePrice < $oldSalePrice) || 
                 (!$oldSalePrice && $newSalePrice < $originalPrice))) {
                 
                $oldPriceToDisplay = $oldSalePrice ?: $originalPrice;
                dispatch(new \App\Jobs\SendWishlistPriceDropEmail($product, $oldPriceToDisplay));
            }
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
