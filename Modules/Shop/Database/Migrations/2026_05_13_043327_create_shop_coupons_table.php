<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shop_coupons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique(); // Contoh: PUANPAYDAY
            $table->enum('type', ['fixed', 'percent'])->default('fixed'); 
            $table->decimal('value', 15, 2); // Nominal diskon
            $table->decimal('min_total', 15, 2)->default(0); // Syarat minimal belanja
            $table->boolean('is_first_order_only')->default(false); // Syarat untuk pelanggan pertama kali
            $table->boolean('is_active')->default(true);
            $table->date('expired_at')->nullable();
            $table->timestamps();
        });

        // Menambahkan kolom untuk mencatat kupon di keranjang
        Schema::table('shop_carts', function (Blueprint $table) {
            $table->string('coupon_code')->nullable()->after('grand_total');
        });
    }

    public function down()
    {
        Schema::table('shop_carts', function (Blueprint $table) {
            $table->dropColumn('coupon_code');
        });
        Schema::dropIfExists('shop_coupons');
    }
};