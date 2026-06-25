<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Review extends Model
{
    protected $table = 'shop_reviews';
    protected $fillable = ['user_id', 'product_id', 'order_id', 'rating', 'comment', 'status'];

    public function product()
    {
        return $this->belongsTo(\Modules\Shop\Entities\Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function order()
    {
        return $this->belongsTo(\Modules\Shop\Entities\Order::class, 'order_id');
    }
}