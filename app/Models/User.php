<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Traits\UuidTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UuidTrait;

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(\Modules\Shop\Entities\Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(\Modules\Shop\Entities\Address::class);
    }

    public function wishlists()
    {
        return $this->hasMany(\Modules\Shop\Entities\Wishlist::class);
    }

    public function carts()
    {
        return $this->hasMany(\Modules\Shop\Entities\Cart::class);
    }

    public function conversations()
    {
        return $this->hasMany(\App\Models\Conversation::class);
    }

    /**
     * Menghitung rentang budget historis pengguna berdasarkan pesanannya yang sudah selesai.
     */
    public function getHistoricalBudgetRange()
    {
        return \Illuminate\Support\Facades\Cache::remember("user_{$this->id}_budget_range", now()->addDay(), function () {
            $prices = \Illuminate\Support\Facades\DB::table('shop_order_items as soi')
                ->join('shop_orders as so', 'soi.order_id', '=', 'so.id')
                ->where('so.user_id', $this->id)
                ->whereIn('so.status', [\Modules\Shop\Entities\Order::STATUS_RECEIVED, 'COMPLETED'])
                ->selectRaw('MIN(soi.base_price) as min_price, MAX(soi.base_price) as max_price')
                ->first();

            if (!$prices || !$prices->min_price || !$prices->max_price) {
                return null;
            }

            // Tambahkan ruang toleransi 20%
            $minBudget = max(0, $prices->min_price * 0.8);
            $maxBudget = $prices->max_price * 1.2;

            return [
                'min' => (int) $minBudget,
                'max' => (int) $maxBudget,
            ];
        });
    }
}
