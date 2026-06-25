<?php

namespace Modules\Shop\Entities;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnClaim extends Model
{
    use HasUuids;

    protected $table = 'shop_returns';

    protected $fillable = [
        'order_id',
        'user_id',
        'reason',
        'proof_image',
        'status',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'admin_note',
        'return_method',
    ];

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_REJECTED = 'REJECTED';

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function rejecter(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'rejected_by');
    }
}
