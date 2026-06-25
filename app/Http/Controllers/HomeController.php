<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\Category;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\OrderItem;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        // 1. Ambil 8 produk terbaru (Hanya Produk Induk/Parent yang punya foto)
        $products = Product::whereNull('parent_id')
                            ->whereNotNull('featured_image')
                            ->orderBy('created_at', 'desc')
                            ->take(8)
                            ->get();

        // 2. Ambil kategori beserta produknya (Eager Loading)
        $categories = Category::with(['products' => function ($query) {
            $query->whereNull('parent_id')->whereNotNull('featured_image');
        }])->get();

        // 3. Ambil rekomendasi produk yang dipersonalisasi
        $recommendedProducts = $this->getPersonalizedRecommendations();

        // 4. Kirim data ke tampilan
        return view('themes.gallerypuan.home', compact('products', 'categories', 'recommendedProducts'));
    }

    /**
     * Mengambil rekomendasi produk yang dipersonalisasi untuk user yang sedang login.
     *
     * Algoritma (berurutan):
     *   1. Identifikasi 1 kategori favorit berdasarkan total qty yang dibeli dari order SELESAI.
     *   2. Tarik 5 produk ACTIVE & IN_STOCK dari kategori tersebut, kecuali yang sudah dibeli.
     *   3. Fallback: jika belum login / belum ada transaksi, kembalikan 5 produk terbaru.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPersonalizedRecommendations()
    {
        // =====================================================================
        // LANGKAH 1: Identifikasi Kategori Favorit Pengguna
        // =====================================================================
        // Kita hanya bisa melakukan ini jika user sudah login.
        if (Auth::check()) {
            $user = Auth::user();

            // Subquery: cari category_id dengan total qty pembelian terbanyak
            // dari order milik user ini yang sudah berstatus RECEIVED atau COMPLETED.
            $favouriteCategoryId = DB::table('shop_order_items as soi')
                ->select('scp.category_id', DB::raw('SUM(soi.qty) as total_qty'))
                // Join ke tabel order untuk filter status
                ->join('shop_orders as so', 'soi.order_id', '=', 'so.id')
                // Join ke pivot kategori-produk
                ->join('shop_categories_products as scp', 'soi.product_id', '=', 'scp.product_id')
                // Hanya hitung milik user yang sedang login
                ->where('so.user_id', $user->id)
                // Constraint Wajib: hanya order yang sudah selesai
                ->whereIn('so.status', [
                    Order::STATUS_RECEIVED,   // 'RECEIVED'
                    'COMPLETED',              // alias yang ada di beberapa flow
                ])
                ->groupBy('scp.category_id')
                ->orderByDesc('total_qty')
                ->value('category_id'); // Ambil hanya 1 category_id teratas

            // =====================================================================
            // LANGKAH 2: Tarik Produk Rekomendasi dari Kategori Favorit
            // =====================================================================
            if ($favouriteCategoryId) {

                // Subquery ID produk yang sudah pernah dibeli user ini
                // (dari semua order, bukan hanya yang COMPLETED)
                $purchasedProductIds = DB::table('shop_order_items as soi')
                    ->join('shop_orders as so', 'soi.order_id', '=', 'so.id')
                    ->where('so.user_id', $user->id)
                    ->pluck('soi.product_id');

                $recommendations = Product::with([
                        'categories',
                        'images',
                        'image',
                        'inventory',
                        'variants',
                        'variants.inventory',
                    ])
                    // Produk harus berada di kategori favorit
                    ->whereHas('categories', function ($query) use ($favouriteCategoryId) {
                        $query->where('shop_categories.id', $favouriteCategoryId);
                    })
                    // Hanya produk induk (parent) yang tampil di listing
                    ->whereNull('parent_id')
                    ->whereNotNull('featured_image')
                    // Constraint: status ACTIVE (sesuai konstanta di Product model)
                    ->where('status', Product::ACTIVE)
                    // Constraint: stok tersedia
                    ->where('stock_status', Product::STATUS_IN_STOCK)
                    // Pengecualian: jangan tampilkan yang sudah pernah dibeli
                    ->whereNotIn('id', $purchasedProductIds)
                    ->latest()
                    ->take(5)
                    ->get();

                // Jika produk rekomendasi ditemukan, kembalikan langsung
                if ($recommendations->isNotEmpty()) {
                    return $recommendations;
                }
            }
        }

        // =====================================================================
        // LANGKAH 3: Fallback — User Baru / Belum Login / Rekomendasi Kosong
        // =====================================================================
        // Kembalikan 5 produk terbaru yang ACTIVE dan IN_STOCK sebagai default.
        return Product::with([
                'categories',
                'images',
                'image',
                'inventory',
                'variants',
                'variants.inventory',
            ])
            ->whereNull('parent_id')
            ->whereNotNull('featured_image')
            ->where('status', Product::ACTIVE)
            ->where('stock_status', Product::STATUS_IN_STOCK)
            ->latest()
            ->take(5)
            ->get();
    }
}