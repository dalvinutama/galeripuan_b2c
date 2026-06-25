<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;
use Modules\Shop\Repositories\Front\Interfaces\CategoryRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    protected $defaultPriceRange;
    protected $sortingQuery;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        parent::__construct();

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        
        // Range default hijab (Dibuat maksimal 10 juta agar semua produk tampil awal)
        $this->defaultPriceRange = [
            'min' => 0,
            'max' => 10000000,
        ];

        $this->data['categories'] = $this->categoryRepository->findAll();
        $this->data['filter']['price'] = $this->defaultPriceRange;

        $this->sortingQuery = null;
        $this->data['sortingQuery'] = $this->sortingQuery;
        $this->data['sortingOptions'] = [
            '' => '-- Sort Products --',
                        '' => '-- Urutkan Produk --',
                '?sort=price&order=asc' => 'Harga: Rendah ke Tinggi',
                '?sort=price&order=desc' => 'Harga: Tinggi ke Rendah',
                '?sort=publish_date&order=desc' => 'Barang Terbaru',
                    ];
    }

    public function index(Request $request)
    {
        $priceFilter = $this->getPriceRangeFilter($request);

        $options = [
            'per_page' => $request->get('show') ?? $this->perPage,
            'sort' => $request->get('sort'), // Mempertahankan fitur sortir
            'filter' => [
                'price' => $priceFilter,
                'q' => $request->get('q'), // <-- TAMBAHKAN BARIS INI
                'promo' => $request->get('promo') === 'true',
            ],
        ];

        $this->data['filter']['price'] = $priceFilter;

        if ($request->get('sort')) {
            $sort = $this->sortingRequest($request);
            $options['sort'] = $sort;

            $this->sortingQuery = '?sort=' . $sort['sort'] . '&order=' . $sort['order'];
            
            $this->data['sortingQuery'] = $this->sortingQuery;
        }

        $this->data['products'] = $this->productRepository->findAll($options);

        return $this->loadTheme('products.index', $this->data);
    }

    public function category(Request $request, $categorySlug)
    {
        $category = $this->categoryRepository->findBySlug($categorySlug);
        $priceFilter = $this->getPriceRangeFilter($request);

        $options = [
            'per_page' => $request->get('show') ?? $this->perPage,
            'sort' => $request->get('sort'), // Mempertahankan fitur sortir
            'filter' => [
                'category' => $categorySlug,
                'price' => $priceFilter,
            ]
        ];

        $this->data['filter']['price'] = $priceFilter;

        if ($request->get('sort')) {
            $sort = $this->sortingRequest($request);
            $options['sort'] = $sort;
            $this->sortingQuery = '?sort=' . $sort['sort'] . '&order=' . $sort['order'];
            $this->data['sortingQuery'] = $this->sortingQuery;
        }

        $this->data['products'] = $this->productRepository->findAll($options);
        $this->data['category'] = $category;

        return $this->loadTheme('products.category', $this->data);
    }



    public function show($categorySlug, $productSlug)
    {
        // Cari produk dengan mencocokkan format slug-sku
        $product = \Modules\Shop\Entities\Product::whereRaw('CONCAT(slug, "-", sku) = ?', [$productSlug])->firstOrFail();

        if ($product) {
            $product->increment('views_count');
        }

        $this->data['product'] = $product;

        return $this->loadTheme('products.show', $this->data);
    }

    protected function getPriceRangeFilter(Request $request)
    {
        if (!$request->has('price') || empty($request->get('price'))) {
            // Apply Dynamic Personalization if logged in
            if (\Illuminate\Support\Facades\Auth::check()) {
                $budget = \Illuminate\Support\Facades\Auth::user()->getHistoricalBudgetRange();
                if ($budget) {
                    $this->data['isDynamicFilterApplied'] = true;
                    return $budget;
                }
            }
            return $this->defaultPriceRange;
        }

        // Clean any string format like "Rp " or "IDR " to get only numbers
        $cleanPriceString = $request->get('price');
        $prices = explode('-', $cleanPriceString);

        if (count($prices) < 2) {
            return $this->defaultPriceRange;
        }

        $min = (int) preg_replace('/[^0-9]/', '', $prices[0]);
        $max = (int) preg_replace('/[^0-9]/', '', $prices[1]);

        return [
            'min' => $min,
            'max' => $max,
        ];
    }

    function sortingRequest(Request $request) {
        $sort = [];

        if ($request->get('sort') && $request->get('order')) {
            $sort = [
                'sort' => $request->get('sort'),
                'order' => $request->get('order'),
            ];
        } else if ($request->get('sort')) {
            $sort = [
                'sort' => $request->get('sort'),
                'order' => 'desc',
            ];
        }

        return $sort;
    }
}