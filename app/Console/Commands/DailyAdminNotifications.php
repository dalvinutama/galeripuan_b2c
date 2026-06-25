<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use App\Notifications\AdminNotification;
use Modules\Shop\Entities\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyAdminNotifications extends Command
{
    protected $signature = 'admin:daily-notifications';
    protected $description = 'Send daily operational notifications to admins (Vouchers expiring, Best sellers, etc.)';

    public function handle()
    {
        $admins = Admin::all();

        // 1. Voucher Mau Kadaluarsa (Dalam 3 hari)
        $expiringVouchers = DB::table('shop_vouchers')
            ->where('is_active', 1)
            ->whereNotNull('expired_at')
            ->whereDate('expired_at', '<=', Carbon::now()->addDays(3)->toDateString())
            ->whereDate('expired_at', '>=', Carbon::now()->toDateString())
            ->get();

        foreach ($expiringVouchers as $voucher) {
            foreach ($admins as $admin) {
                $admin->notify(new AdminNotification(
                    'Voucher Akan Kedaluwarsa',
                    "Voucher '{$voucher->code}' akan kedaluwarsa pada " . Carbon::parse($voucher->expired_at)->format('d M Y') . ". Segera periksa!",
                    '/admin/vouchers'
                ));
            }
        }

        // 2. Produk Laris Manis (Dibeli > 5 kali dalam 24 jam terakhir)
        $yesterday = Carbon::now()->subHours(24);
        $bestSellers = DB::table('shop_order_items')
            ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.created_at', '>=', $yesterday)
            ->whereNotIn('shop_orders.status', ['cancelled', 'failed'])
            ->select('shop_order_items.product_id', 'shop_order_items.name', DB::raw('SUM(shop_order_items.qty) as total_qty'))
            ->groupBy('shop_order_items.product_id', 'shop_order_items.name')
            ->having('total_qty', '>=', 5)
            ->get();

        foreach ($bestSellers as $product) {
            foreach ($admins as $admin) {
                $admin->notify(new AdminNotification(
                    'Produk Laris Manis! 🔥',
                    "Produk '{$product->name}' terjual {$product->total_qty} pcs dalam 24 jam terakhir. Pastikan stok aman!",
                    '/admin/products'
                ));
            }
        }

        $this->info('Daily admin notifications sent successfully.');
    }
}
