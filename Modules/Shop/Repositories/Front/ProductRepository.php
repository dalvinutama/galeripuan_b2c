<?php

namespace Modules\Shop\Repositories\Front;

use Modules\Shop\Entities\Category;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\Tag;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;
use Modules\Shop\Services\ProductSearchService;

class ProductRepository implements ProductRepositoryInterface {

    public function __construct(
        private ProductSearchService $searchService
    ) {}

    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $categorySlug = $options['filter']['category'] ?? null;
        $tagSlug = $options['filter']['tag'] ?? null;
        $priceFilter = $options['filter']['price'] ?? null;
        $keyword = $options['filter']['q'] ?? null;
        $promo = $options['filter']['promo'] ?? false;
        $sort = $options['sort'] ?? null; 

        $products = Product::with(['categories'])->whereNull('parent_id');

        if ($keyword) {
            $products = $this->searchService->applySearch($products, $keyword);
        }

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $childCategoryIDs = Category::childIDs($category->id);
            $categoryIDs = array_merge([$category->id], $childCategoryIDs);

            $products = $products->whereHas('categories', function ($query) use ($categoryIDs) {
                $query->whereIn('shop_categories.id', $categoryIDs);
            });
        }

        if ($tagSlug) {
            $tag = Tag::where('slug', $tagSlug)->firstOrFail();
            $products = $products->whereHas('tags', function ($query) use ($tag) {
                $query->where('shop_tags.id', $tag->id);
            });
        }

        if ($priceFilter) {
            $products = $products->where('price', '>=', $priceFilter['min'])
                                ->where('price', '<=', $priceFilter['max']);
        }

        if ($promo) {
            $products = $products->orderByRaw('CASE WHEN sale_price > 0 THEN 1 ELSE 2 END ASC');
        }

        if (is_array($sort) && isset($sort['sort']) && isset($sort['order'])) {
            $kolom = $sort['sort'] == 'publish_date' ? 'created_at' : $sort['sort'];
            $products = $products->orderBy($kolom, $sort['order']);
        } elseif (is_string($sort)) {
            if ($sort == 'price_low_high') {
                $products = $products->orderBy('price', 'asc'); 
            } elseif ($sort == 'price_high_low') {
                $products = $products->orderBy('price', 'desc'); 
            } else {
                $products = $products->orderBy('created_at', 'desc');
            }
        } else {
            if ($keyword) {
                $products = $this->searchService->applyRelevanceOrder($products, $keyword);
            }
            
            $products = $products->orderBy('created_at', 'desc');
        }

        if ($perPage) {
            return $products->paginate($perPage);
        }

        return $products->get();
    }
        
        public function findBySKU($sku)
        {
            return Product::where('sku', $sku)->firstOrFail();
        }

        public function findByID($id)
    {
        return Product::where('id', $id)->firstOrFail();
    }
}
