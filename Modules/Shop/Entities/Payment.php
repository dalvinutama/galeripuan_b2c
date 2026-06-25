<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'shop_payments';

    protected $fillable = [
        'user_id',
        'order_id',
        'payment_type',
        'status',
        'approved_by',
        'approved_at',
        'note',
        'rejected_by',
        'rejected_at',
        'rejection_note',
        'amount',
        'payloads',
        'token',
    ];

    protected $casts = [
        'payloads' => 'json',
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
