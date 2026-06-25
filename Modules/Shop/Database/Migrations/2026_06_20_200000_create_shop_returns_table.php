<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shop_returns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->uuid('user_id');
            $table->text('reason');
            $table->string('proof_image', 200)->nullable();
            $table->string('status', 20)->default('PENDING');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->datetime('rejected_at')->nullable();
            $table->text('admin_note')->nullable();
            $table->string('return_method', 20)->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('shop_orders');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('admins');
            $table->foreign('rejected_by')->references('id')->on('admins');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shop_returns');
    }
};
