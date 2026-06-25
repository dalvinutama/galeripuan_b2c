<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Pastikan namespace user-mu benar
use Modules\Shop\Entities\Product;

class Wishlist extends Model
{
    protected $table = 'shop_wishlists';
    protected $fillable = ['user_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}