<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shop_addresses', function (Blueprint $table) {
            // Tambahkan kolom ID setelah nama kotanya
            $table->integer('province_id')->nullable()->after('province');
            $table->integer('city_id')->nullable()->after('city');
        });
    }

    public function down()
    {
        Schema::table('shop_addresses', function (Blueprint $table) {
            $table->dropColumn(['province_id', 'city_id']);
        });
    }
};