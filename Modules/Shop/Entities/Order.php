<?php

namespace Modules\Shop\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory, HasUuids;


    protected $table = 'shop_orders';

    protected $fillable = [
        'user_id',
        'code',
        'status',
        'approved_by',
        'approved_at',
        'cancelled_by',
        'cancelled_at',
        'cancellation_note',
        'order_date',
        'payment_due',
        'payment_url',
        'base_total_price',
        'tax_amount',
        'tax_percent',
        'discount_amount',
        'discount_percent',
        'shipping_cost',
        'shipping_courier',
        'shipping_number',
        'grand_total',
        'voucher_code',
        'customer_note',
        'customer_first_name',
        'customer_last_name',
        'customer_address1',
        'customer_address2',
        'customer_phone',
        'customer_email',
        'customer_city',
        'customer_province',
        'customer_postcode',
    ];

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_CONFIRMED = 'CONFIRMED';
    public const STATUS_PACKAGING = 'PACKAGING';
    public const STATUS_DELIVERED = 'DELIVERED';
    public const STATUS_RECEIVED = 'RECEIVED';
    public const STATUS_CANCELLED = 'CANCELLED';
    public const STATUS_RETURNED = 'RETURNED';

    public const ACTION_CONFIRM = 'CONFIRM';
    public const ACTION_PACKING = 'PACKING';
    public const ACTION_DELIVER = 'DELIVER';
    public const ACTION_CANCEL = 'CANCEL';
    public const ACTION_CONFIRM_RECEIVED = 'CONFIRM_RECEIVED';

    public const ACTION_LABELS = [
        self::ACTION_CONFIRM => 'Konfirmasi',
        self::ACTION_PACKING => 'Pengemasan',
        self::ACTION_DELIVER => 'Pengiriman',
        self::ACTION_CANCEL => 'Pembatalan',
        self::ACTION_CONFIRM_RECEIVED => 'Konfirmasi Diterima',
    ];

    public const ORDER_CODE = 'ORDER';
    
    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\OrderFactory::new();
    }

    public function items() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function returnClaim()
    {
        return $this->hasOne(\Modules\Shop\Entities\ReturnClaim::class, 'order_id');
    }

    public static function generateCode()
    {
        $dateCode = self::ORDER_CODE . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

        $lastOrder = self::select([DB::raw('MAX(shop_orders.code) AS last_code')])
            ->where('code', 'like', $dateCode . '%')
            ->first();

        $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;

        $orderCode = $dateCode . '00001';
        if ($lastOrderCode) {
            $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
            $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);

            $orderCode = $dateCode . $nextOrderNumber;
        }

        if (self::isCodeExists($orderCode)) {
            return self::generateCode();
        }

        return $orderCode;
    }

    private static function isCodeExists($orderCode)
    {
        return Order::where('code', '=', $orderCode)->exists();
    }

    public function getOrderDateFormattedAttribute(): string
    {
        return Carbon::parse($this->attributes['order_date'])->format('d M Y H:i');
    }

    // 1. Ubah menjadi PUBLIC dan tidak perlu pakai parameter
    public function getNextActionAndStatus() 
    {
        // 2. Ambil status langsung dari database, hapus spasi, dan jadikan huruf besar
        $status = strtoupper(trim($this->status));

        switch ($status) {
            case 'PENDING':
            case 'CREATED': 
            case 'UNPAID':    // Tambahkan UNPAID untuk jaga-jaga kalau status tertahan
                return [
                    'action' => self::ACTION_CONFIRM,
                    'action_label' => self::ACTION_LABELS[self::ACTION_CONFIRM],
                    'status' => 'processing', 
                ];
            case 'CONFIRMED':
            case 'PROCESSING':
            case 'PAID':      // Tambahkan PAID untuk jaga-jaga
                return [
                    'action' => self::ACTION_PACKING,
                    'action_label' => self::ACTION_LABELS[self::ACTION_PACKING],
                    'status' => 'packaging', 
                ];
            case 'PACKAGING':
                return [
                    'action' => self::ACTION_DELIVER,
                    'action_label' => self::ACTION_LABELS[self::ACTION_DELIVER],
                    'status' => 'delivered', 
                ];
            case 'DELIVERED':
                return [
                    'action' => self::ACTION_CONFIRM_RECEIVED,
                    'action_label' => self::ACTION_LABELS[self::ACTION_CONFIRM_RECEIVED],
                    'status' => 'received', 
                ];
            case 'RECEIVED':
            case 'COMPLETED':
                return [
                    'action' => null,
                    'action_label' => 'Selesai',
                    'status' => 'received',
                ];
            case 'CANCELLED':
                return [
                    'action' => null,
                    'action_label' => 'Dibatalkan',
                    'status' => 'cancelled',
                ];
            case 'RETURNED':
                return [
                    'action' => null,
                    'action_label' => 'Dikembalikan',
                    'status' => 'returned',
                ];
            default:
                abort(403, 'Unknown process untuk status: [' . $status . ']. Tolong cek databasemu!');
        }
    }

    public function getStatusBadgeAttribute()
    {
        $status = strtoupper(trim($this->status));
        return match($status) {
            'CREATED', 'PENDING', 'UNPAID' => 'bg-warning text-dark',
            'PAID', 'CONFIRMED', 'PROCESSING' => 'bg-info text-dark',
            'PACKAGING', 'DELIVERED' => 'bg-primary text-white',
            'RECEIVED', 'COMPLETED' => 'bg-success text-white',
            'CANCELLED' => 'bg-danger text-white',
            'RETURNED' => 'bg-secondary text-white',
            default => 'bg-secondary text-white',
        };
    }

    public function getPaymentMethodAttribute()
    {
        return $this->payment ? $this->payment->payment_type : null;
    }

    public function payment()
    {
        return $this->hasOne(\Modules\Shop\Entities\Payment::class);
    }

    public function reduceStock()
    {
        if ($this->items->count() > 0) {
            foreach ($this->items as $item) {
                // 1. Deduct variant / item stock
                $inventory = \Modules\Shop\Entities\ProductInventory::where('product_id', $item->product_id)->first();
                if ($inventory) {
                    $inventory->qty -= $item->qty;
                    $inventory->save();
                    
                    // Update variant stock_status
                    if ($item->product) {
                        $item->product->stock_status = $inventory->qty > 0 ? \Modules\Shop\Entities\Product::STATUS_IN_STOCK : \Modules\Shop\Entities\Product::STATUS_OUT_OF_STOCK;
                        $item->product->save();
                    }

                    // Notify admin if stock is low or out
                    $threshold = $inventory->low_stock_threshold ?? 5;
                    if ($inventory->qty <= 0) {
                        $productName = $item->product->name ?? 'Produk';
                        $this->notifyAdminStock($productName, $inventory->qty, 'Habis');
                    } elseif ($inventory->qty <= $threshold) {
                        $productName = $item->product->name ?? 'Produk';
                        $this->notifyAdminStock($productName, $inventory->qty, 'Menipis');
                    }
                }

                // 2. Deduct parent product stock if applicable
                if ($item->product && $item->product->parent_id) {
                    $parentInventory = \Modules\Shop\Entities\ProductInventory::where('product_id', $item->product->parent_id)->first();
                    if ($parentInventory) {
                        $parentInventory->qty -= $item->qty;
                        $parentInventory->save();

                        // Update parent stock_status
                        $item->product->parent->stock_status = $parentInventory->qty > 0 ? \Modules\Shop\Entities\Product::STATUS_IN_STOCK : \Modules\Shop\Entities\Product::STATUS_OUT_OF_STOCK;
                        $item->product->parent->save();

                        // Notify admin if parent stock is low or out
                        $parentThreshold = $parentInventory->low_stock_threshold ?? 5;
                        if ($parentInventory->qty <= 0) {
                            $parentName = $item->product->parent->name ?? 'Produk Induk';
                            $this->notifyAdminStock($parentName, $parentInventory->qty, 'Habis');
                        } elseif ($parentInventory->qty <= $parentThreshold) {
                            $parentName = $item->product->parent->name ?? 'Produk Induk';
                            $this->notifyAdminStock($parentName, $parentInventory->qty, 'Menipis');
                        }
                    }
                }
            }
        }
    }

    private function notifyAdminStock($productName, $qty, $status)
    {
        try {
            $admins = \App\Models\Admin::all();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\AdminNotification(
                    'Stok ' . ($status === 'Habis' ? 'Habis' : 'Menipis'),
                    'Stok ' . $productName . ' ' . ($status === 'Habis' ? 'sudah habis' : 'tersisa ' . $qty . ' pcs') . '.',
                    '/admin/products'
                ));
            }
        } catch (\Exception $e) {
            // Fail silently — stock notification is non-critical
        }
    }
}
