<?php

namespace App\Livewire\Admin\Product;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Shop\Entities\Product;
use Illuminate\Support\Str;

class ProductCreate extends Component
{
    public $sku, $name, $type;

    protected function rules()
    {
        return [
            'sku' => [
                'required',
                'string',
                Rule::unique('shop_products', 'sku'),
            ],
            'name' => [
                'required',
                'string',
            ],
            'type' => [
                'required',
                'string',
            ]
        ];
    }
    
    public function render()
    {
        return view('livewire.admin.product.product-create')->layout('components.layouts.app');
    }

    public function save()
    {
        $params = $this->validate();
        
        $params['user_id'] = auth()->id();
        
        $params['slug'] = Str::slug($params['name']);
        $params['status'] = Product::INACTIVE;

        try {
            // Kita coba simpan ke database
            if ($product = Product::create($params)) {
                session()->flash('success', 'Produk berhasil dibuat! Silakan lengkapi data.');
    
                $this->reset();
    
                return redirect()->route('admin.products.update', ['id' => $product->id]);
            }
        } catch (\Throwable $e) {
            // Jika database masih protes, tangkap errornya biar layarnya nggak merah!
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
    public function close()
    {
        $this->reset();
    }
}