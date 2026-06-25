<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class Voucher extends Model
{
    use UuidTrait;

    protected $table = 'shop_vouchers';

    // Tambahkan description dan min_order_count
    protected $fillable = [
        'code', 'description', 'type', 'value', 'min_total', 'is_first_order_only', 'min_order_count', 'is_active', 'expired_at'
    ];
}