<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            // Menambah kolom coupon_code setelah grand_total
            $table->string('coupon_code')->nullable()->after('grand_total');
        });
    }

    public function down()
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropColumn('coupon_code');
        });
    }
};