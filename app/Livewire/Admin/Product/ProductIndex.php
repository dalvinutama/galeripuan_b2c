<?php

namespace App\Livewire\Admin\Product;

use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Shop\Entities\Product;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB; // <--- 1. INI WAJIB DITAMBAHKAN!

class ProductIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;

    #[Url(as: 'q')]
    public ?string $search;

    public function render()
    {
        $products = Product::whereNull('parent_id')->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $products = $products->where('name', 'LIKE', '%'. $this->search . '%');
        }

        return view('livewire.admin.product.product-index', [
            'products' => $products->paginate($this->perPage),
        ])->layout('components.layouts.app');
    }

    public function delete($id)
    {
        try {
            // Hapus varian-varian beserta dependensinya terlebih dahulu
            $variants = Product::where('parent_id', $id)->get();
            foreach ($variants as $variant) {
                DB::table('shop_product_inventories')->where('product_id', $variant->id)->delete();
                DB::table('shop_cart_items')->where('product_id', $variant->id)->delete();
                DB::table('shop_order_items')->where('product_id', $variant->id)->delete();
                $variant->delete();
            }

            // Hapus dependensi produk utama
            DB::table('shop_categories_products')->where('product_id', $id)->delete();
            DB::table('shop_product_inventories')->where('product_id', $id)->delete();
            DB::table('shop_product_images')->where('product_id', $id)->delete();
            DB::table('shop_cart_items')->where('product_id', $id)->delete();
            DB::table('shop_order_items')->where('product_id', $id)->delete();
            DB::table('shop_wishlists')->where('product_id', $id)->delete();
            DB::table('shop_reviews')->where('product_id', $id)->delete();

            // 3. BARU KITA HAPUS BAPAKNYA (PRODUK)
            $product = Product::findOrFail($id);
            $product->delete();

            session()->flash('success', 'Product deleted!');
            
        // Ganti bagian catch di fungsi delete($id) menjadi ini:
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menghapus produk: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    public function changePerPage($perPage)
    {
        if (($perPage < 5) || ($perPage > 25)) {
            $this->perPage = 5;
            return;
        }

        $this->perPage = $perPage;
    }
}