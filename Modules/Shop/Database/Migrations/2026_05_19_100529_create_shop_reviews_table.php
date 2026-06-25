<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_reviews', function (Blueprint $table) {
            $table->id();
            
            // 1. Tali Penghubung ke Pelanggan (UUID)
            $table->char('user_id', 36); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // 2. Tali Penghubung ke Produk (UUID)
            $table->char('product_id', 36); 
            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');

            // 3. Tali Penghubung ke Pesanan (UUID) - INI YANG DIPERBAIKI
            $table->char('order_id', 36);
            $table->foreign('order_id')->references('id')->on('shop_orders')->onDelete('cascade');

            // Data Ulasannya
            $table->tinyInteger('rating')->default(5);
            $table->text('comment')->nullable();
            $table->string('status')->default('approved');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_reviews');
    }
};