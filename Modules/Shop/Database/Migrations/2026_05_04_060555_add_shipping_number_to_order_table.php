<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            // Kita pakai logic IF agar tidak error jika kolom sudah ada atau belum ada
            
            if (!Schema::hasColumn('shop_orders', 'payment_status')) {
                $table->string('payment_status')->nullable()->after('status');
            }

            if (!Schema::hasColumn('shop_orders', 'shipping_courier')) {
                $table->string('shipping_courier')->nullable()->after('payment_status');
            }

            if (!Schema::hasColumn('shop_orders', 'shipping_service_name')) {
                $table->string('shipping_service_name', 100)->nullable()->after('shipping_courier');
            }

            if (!Schema::hasColumn('shop_orders', 'shipping_number')) {
                $table->string('shipping_number')->nullable()->after('shipping_service_name')->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'shipping_courier',
                'shipping_service_name',
                'shipping_number'
            ]);
        });
    }
};