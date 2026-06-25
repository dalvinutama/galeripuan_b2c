<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_wishlists', function (Blueprint $table) {
            $table->id();
            
            // Tali Penghubung 1: Ke tabel users (UUID)
            $table->char('user_id', 36); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Tali Penghubung 2: Ke tabel shop_products (Ternyata UUID juga!)
            $table->char('product_id', 36); 
            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_wishlists');
    }
};