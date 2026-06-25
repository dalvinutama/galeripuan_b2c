<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shop_coupons', function (Blueprint $table) {
            $table->string('description')->nullable()->after('code'); // Penjelasan promo
            $table->integer('min_order_count')->default(0)->after('is_first_order_only'); // Syarat pesanan ke-berapa
        });
    }

    public function down()
    {
        Schema::table('shop_coupons', function (Blueprint $table) {
            $table->dropColumn(['description', 'min_order_count']);
        });
    }
};