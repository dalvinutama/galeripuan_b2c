<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('shop_coupons', 'shop_vouchers');

        if (Schema::hasColumn('shop_orders', 'coupon_code')) {
            Illuminate\Support\Facades\DB::statement('ALTER TABLE shop_orders CHANGE coupon_code voucher_code VARCHAR(255) DEFAULT NULL');
        }

        if (Schema::hasColumn('shop_carts', 'coupon_code')) {
            Illuminate\Support\Facades\DB::statement('ALTER TABLE shop_carts CHANGE coupon_code voucher_code VARCHAR(255) DEFAULT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('shop_carts', 'voucher_code')) {
            Illuminate\Support\Facades\DB::statement('ALTER TABLE shop_carts CHANGE voucher_code coupon_code VARCHAR(255) DEFAULT NULL');
        }

        if (Schema::hasColumn('shop_orders', 'voucher_code')) {
            Illuminate\Support\Facades\DB::statement('ALTER TABLE shop_orders CHANGE voucher_code coupon_code VARCHAR(255) DEFAULT NULL');
        }

        Schema::rename('shop_vouchers', 'shop_coupons');
    }
};
