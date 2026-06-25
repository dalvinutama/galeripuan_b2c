<?php

namespace App\Livewire\Admin\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductImage;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;
// 👇 TAMBAHAN 1: Import Model Category 👇
use Modules\Shop\Entities\Category;

class ProductUpdate extends Component
{   
    use WithFileUploads;

    public $id;
    public Product $product;

    public $image;
    
    // 👇 TAMBAHAN 2: Wadah untuk menyimpan pilihan kategori 👇
    public $category_ids = [];

    // Wadah untuk varian produk
    public $variants = [];

    public string $sku, $name, $excerpt, $body, $status;
    public bool $manage_stock;
    public $price;
    public $sale_price;
    public int $qty, $low_stock_threshold;
    public $weight;


    private $productRepository;

    public function boot(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function mount()
    {
        $this->product = $this->productRepository->findByID($this->id);

        $this->weight = $this->product->weight;

        $this->sku = $this->product->sku;
        $this->name = $this->product->name;
        $this->excerpt = (string) $this->product->excerpt;
        $this->body = (string) $this->product->body;
        // Cast ke int: membuang desimal ".00" agar tidak tampil "45000.00" di form
        $this->price      = (int) $this->product->price;
        $this->sale_price = $this->product->sale_price ? (int) $this->product->sale_price : null;
        $this->status = $this->product->status;

        $this->manage_stock = $this->product->manage_stock;

        if ($this->product->manage_stock && $this->product->inventory) {
            $this->qty = $this->product->inventory->qty;
            $this->low_stock_threshold = $this->product->inventory->low_stock_threshold;
        }

        if ($this->product->categories) {
            $this->category_ids = $this->product->categories->pluck('id')->toArray();
        }

        if ($this->product->type == Product::CONFIGURABLE) {
            $this->variants = $this->product->variants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'sku' => $variant->sku,
                    'color' => $variant->attributes['color'] ?? '',
                    'price' => (int) $variant->price,
                    'qty' => $variant->inventory ? $variant->inventory->qty : 0,
                ];
            })->toArray();
        }
    }

    protected function rules()
    {
        return [
            'sku' => [
                'required',
                'string',
                Rule::unique('shop_products', 'sku')->ignore($this->product->id),
            ],
            'name' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'sale_price' => [
                'nullable',
                'numeric',
            ],
            'excerpt' => [
                'string',
            ],
            'body' => [
                'string',
            ],
            'status' => [
                'required',
                'string',
            ],
            'category_ids' => [
                'array',
            ],
            'qty' => [
                'numeric',
                'nullable',
                Rule::requiredIf($this->product->manage_stock),
            ],
            'low_stock_threshold' => [
                'numeric',
                'nullable',
            ],
            'weight' => [
                'required',
                'numeric',
            ],
            'variants.*.sku' => [
                'string',
                'required_if:product.type,CONFIGURABLE',
            ],
            'variants.*.color' => [
                'string',
                'required_if:product.type,CONFIGURABLE',
            ],
            'variants.*.price' => [
                'numeric',
            ],
            'variants.*.qty' => [
                'numeric',
            ],
        ];
    }

    public function render()
    {
        // 👇 TAMBAHAN 4: Ambil semua kategori dari database 👇
        $categories = Category::all();

        return view('livewire.admin.product.product-update', [
            'categories' => $categories, // Kirim daftar kategori ke file HTML
        ])->layout('components.layouts.app', [
            'product' => $this->product,
        ]);
    }

    // 👇 INI DIA BAGIAN UPDATE YANG KAMU TANYAKAN 👇
    public function update()
    {
        if (empty($this->sale_price)) {
            $this->sale_price = null;
        }

        $params = $this->validate();

        $updated = DB::transaction(function () use ($params) {
            $updateStatus = $this->product->update([
                'sku' => $params['sku'],
                'name' => $params['name'],
                'price' => $params['price'],
                'sale_price' => $params['sale_price'],
                'excerpt' => $params['excerpt'],
                'body' => $params['body'],
                'status' => $params['status'],
                'weight' => $params['weight'],
            ]); 
            
            $this->updateStock($params);
            $this->product->categories()->sync($this->category_ids);
            
            if ($this->product->type == Product::CONFIGURABLE) {
                $this->saveVariants();
            }

            return $updateStatus; 
        });

        if ($updated) {
            session()->flash('success', 'Product updated!');
            return;
        }

        session()->flash('error', 'Failed');
    }

    public function addVariant()
    {
        $this->variants[] = [
            'id' => null,
            'sku' => $this->product->sku . '-' . rand(100, 999),
            'color' => '',
            'price' => $this->price ?? $this->product->price,
            'qty' => 0,
        ];
    }

    public function removeVariant($index)
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    private function saveVariants()
    {
        // 1. Kumpulkan ID varian yang masih ada di form (yang tidak dihapus oleh user)
        $existingVariantIds = [];
        foreach ($this->variants as $variantData) {
            if (!empty($variantData['id'])) {
                $existingVariantIds[] = $variantData['id'];
            }
        }

        // 2. Hapus varian di database yang ID-nya tidak ada di form (dihapus user)
        Product::where('parent_id', $this->product->id)
            ->whereNotIn('id', $existingVariantIds)
            ->delete();

        // 3. Update varian yang tersisa atau Buat varian yang baru
        $finalVariantIds = [];
        foreach ($this->variants as $variantData) {
            if (!empty($variantData['id'])) {
                $variant = Product::find($variantData['id']);
                if ($variant) {
                    $stockStatus = $variantData['qty'] > 0 ? Product::STATUS_IN_STOCK : Product::STATUS_OUT_OF_STOCK;
                    $variant->update([
                        'sku' => $variantData['sku'],
                        'price' => $variantData['price'],
                        'stock_status' => $stockStatus,
                        'attributes' => ['color' => $variantData['color']],
                    ]);
                    $finalVariantIds[] = $variant->id;
                    
                    if ($variant->inventory) {
                        $variant->inventory->update(['qty' => $variantData['qty']]);
                    } else {
                        $variant->inventory()->create(['qty' => $variantData['qty']]);
                    }
                }
            } else {
                $stockStatus = $variantData['qty'] > 0 ? Product::STATUS_IN_STOCK : Product::STATUS_OUT_OF_STOCK;
                $variant = Product::create([
                    'parent_id' => $this->product->id,
                    'user_id' => $this->product->user_id,
                    'sku' => $variantData['sku'],
                    'type' => Product::SIMPLE,
                    'name' => $this->product->name . ' - ' . $variantData['color'],
                    'slug' => \Illuminate\Support\Str::slug($this->product->name . ' ' . $variantData['color'] . ' ' . uniqid()),
                    'price' => $variantData['price'],
                    'status' => Product::ACTIVE,
                    'stock_status' => $stockStatus,
                    'manage_stock' => true,
                    'attributes' => ['color' => $variantData['color']],
                ]);
                $variant->inventory()->create(['qty' => $variantData['qty']]);
                $finalVariantIds[] = $variant->id;
            }
        }
    }

    public function changeManageStock()
    {
        if ($this->product->manage_stock) {
            $this->product->manage_stock = false;
            $this->product->save();
            return;
        }

        $this->product->manage_stock = true;
        $this->product->save();
    }

    private function updateStock($params)
    {
        if (!$this->product->manage_stock) {
            return;
        }

        if ($this->product->inventory) {
            $this->product->inventory->update([
                'qty' => $params['qty'],
                'low_stock_threshold' => $params['low_stock_threshold'],
            ]);
        } else {
            $this->product->inventory()->create([
                'qty' => $params['qty'],
                'low_stock_threshold' => $params['low_stock_threshold'],
            ]);
        }

        $stockStatus = $params['qty'] > 0 ? Product::STATUS_IN_STOCK : Product::STATUS_OUT_OF_STOCK;
        $this->product->update(['stock_status' => $stockStatus]);
    }


    public function updatedImage()
    {   
        $this->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096']
        ]);

        $productImage = ProductImage::create([
            'product_id' => $this->product->id,
            'name' => $this->image->getClientOriginalName(),
        ]);

        $productImage->addMedia($this->image)->toMediaCollection('products');

        $this->product->refresh();
        session()->flash('success', 'YEAY! Foto berhasil diunggah secara otomatis!');
    }

    public function setFeaturedImage($id)
    {
        $this->product->featured_image = $id;
        $this->product->save();

        session()->flash('success', 'Featured image updated!');
    }

    public function deleteImage($imageId)
    {
        // 1. Cari data gambar berdasarkan Model yang benar
        $image = ProductImage::find($imageId); 
        
        if ($image) {
            // 2. Hapus file fisik dan datanya (Spatie Media Library akan otomatis menghapus file fisiknya saat model dihapus)
            $image->delete();
            
            // 3. Refresh produk agar foto langsung hilang dari layar
            $this->product->refresh(); 
            
            // 4. (Opsional) Kasih notifikasi biar admin tahu fotonya udah kehapus
            session()->flash('success', 'Foto berhasil dihapus!');
        }
    }
}