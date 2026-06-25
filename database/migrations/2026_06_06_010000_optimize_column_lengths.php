<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // ====================================================================
        // 1. users
        // ====================================================================
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 100)->change();
            $table->string('email', 100)->change();
            $table->string('password', 100)->change();
        });

        // ====================================================================
        // 2. password_reset_tokens
        // ====================================================================
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 100)->change();
            $table->string('token', 64)->change();
        });

        // ====================================================================
        // 3. admins
        // ====================================================================
        Schema::table('admins', function (Blueprint $table) {
            $table->string('name', 100)->change();
            $table->string('email', 100)->change();
            $table->string('password', 100)->change();
        });

        // ====================================================================
        // 4. settings
        // ====================================================================
        Schema::table('settings', function (Blueprint $table) {
            $table->string('key', 100)->change();
            $table->string('type', 20)->default('text')->change();
        });

        // ====================================================================
        // 5. setting_images
        // ====================================================================
        Schema::table('setting_images', function (Blueprint $table) {
            $table->string('setting_key', 100)->change();
            $table->string('image_path', 200)->change();
        });

        // ====================================================================
        // 6. conversations
        // ====================================================================
        Schema::table('conversations', function (Blueprint $table) {
            $table->string('uuid', 36)->change();
        });

        // ====================================================================
        // 7. messages - image path (body is text, already correct)
        // ====================================================================
        Schema::table('messages', function (Blueprint $table) {
            $table->string('image', 200)->nullable()->change();
        });

        // ====================================================================
        // 8. shop_categories
        // ====================================================================
        Schema::table('shop_categories', function (Blueprint $table) {
            $table->string('slug', 100)->change();
            $table->string('name', 100)->change();
        });

        // ====================================================================
        // 9. shop_products
        // ====================================================================
        Schema::table('shop_products', function (Blueprint $table) {
            $table->string('sku', 50)->change();
            $table->string('type', 30)->change();
            $table->string('name', 150)->change();
            $table->string('slug', 150)->change();
            $table->string('status', 20)->change();
            $table->string('stock_status', 20)->default('IN_STOCK')->change();
            $table->string('featured_image', 200)->nullable()->change();
        });

        // ====================================================================
        // 10. shop_addresses
        // ====================================================================
        Schema::table('shop_addresses', function (Blueprint $table) {
            $table->string('first_name', 50)->change();
            $table->string('last_name', 50)->change();
            $table->string('address1', 200)->nullable()->change();
            $table->string('address2', 200)->nullable()->change();
            $table->string('phone', 20)->nullable()->change();
            $table->string('email', 100)->nullable()->change();
            $table->string('city', 100)->nullable()->change();
            $table->string('province', 100)->nullable()->change();
            $table->string('label', 30)->nullable()->change();
        });

        // ====================================================================
        // 11. shop_carts
        // ====================================================================
        Schema::table('shop_carts', function (Blueprint $table) {
            $table->string('voucher_code', 30)->nullable()->change();
        });

        // ====================================================================
        // 12. shop_orders
        // ====================================================================
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->string('code', 30)->change();
            $table->string('status', 30)->change();
            $table->string('customer_first_name', 50)->change();
            $table->string('customer_last_name', 50)->change();
            $table->string('customer_address1', 200)->nullable()->change();
            $table->string('customer_address2', 200)->nullable()->change();
            $table->string('customer_phone', 20)->nullable()->change();
            $table->string('customer_email', 100)->nullable()->change();
            $table->string('customer_city', 100)->nullable()->change();
            $table->string('customer_province', 100)->nullable()->change();
            $table->string('payment_status', 30)->nullable()->change();
            $table->string('shipping_courier', 30)->nullable()->change();
            $table->string('shipping_number', 50)->nullable()->change();
            $table->string('voucher_code', 30)->nullable()->change();
        });

        // ====================================================================
        // 13. shop_order_items
        // ====================================================================
        Schema::table('shop_order_items', function (Blueprint $table) {
            $table->string('sku', 50)->change();
            $table->string('type', 30)->change();
            $table->string('name', 150)->change();
        });

        // ====================================================================
        // 14. shop_payments
        // ====================================================================
        Schema::table('shop_payments', function (Blueprint $table) {
            $table->string('payment_type', 50)->change();
            $table->string('status', 30)->change();
        });

        // ====================================================================
        // 15. shop_vouchers (ex shop_coupons)
        // ====================================================================
        Schema::table('shop_vouchers', function (Blueprint $table) {
            $table->string('code', 30)->change();
            $table->string('description', 200)->nullable()->change();
        });

        // ====================================================================
        // 16. shop_product_images
        // ====================================================================
        Schema::table('shop_product_images', function (Blueprint $table) {
            $table->string('name', 200)->nullable()->change();
        });

        // ====================================================================
        // 17. shop_reviews
        // ====================================================================
        Schema::table('shop_reviews', function (Blueprint $table) {
            $table->string('status', 20)->default('approved')->change();
        });
    }

    public function down()
    {
        // Kembalikan ke string(255) default
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 255)->change();
            $table->string('email', 255)->change();
            $table->string('password', 255)->change();
        });

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 255)->change();
            $table->string('token', 255)->change();
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->string('name', 255)->change();
            $table->string('email', 255)->change();
            $table->string('password', 255)->change();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('key', 255)->change();
            $table->string('type', 255)->default('text')->change();
        });

        Schema::table('setting_images', function (Blueprint $table) {
            $table->string('setting_key', 255)->change();
            $table->string('image_path', 255)->change();
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->string('uuid', 255)->change();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->string('image', 255)->nullable()->change();
        });

        Schema::table('shop_categories', function (Blueprint $table) {
            $table->string('slug', 255)->change();
            $table->string('name', 255)->change();
        });

        Schema::table('shop_products', function (Blueprint $table) {
            $table->string('sku', 255)->change();
            $table->string('type', 255)->change();
            $table->string('name', 255)->change();
            $table->string('slug', 255)->change();
            $table->string('status', 255)->change();
            $table->string('stock_status', 255)->default('IN_STOCK')->change();
            $table->string('featured_image', 255)->nullable()->change();
        });

        Schema::table('shop_addresses', function (Blueprint $table) {
            $table->string('first_name', 255)->change();
            $table->string('last_name', 255)->change();
            $table->string('address1', 255)->nullable()->change();
            $table->string('address2', 255)->nullable()->change();
            $table->string('phone', 255)->nullable()->change();
            $table->string('email', 255)->nullable()->change();
            $table->string('city', 255)->nullable()->change();
            $table->string('province', 255)->nullable()->change();
            $table->string('label', 255)->nullable()->change();
        });

        Schema::table('shop_carts', function (Blueprint $table) {
            $table->string('voucher_code', 255)->nullable()->change();
        });

        Schema::table('shop_orders', function (Blueprint $table) {
            $table->string('code', 255)->change();
            $table->string('status', 255)->change();
            $table->string('customer_first_name', 255)->change();
            $table->string('customer_last_name', 255)->change();
            $table->string('customer_address1', 255)->nullable()->change();
            $table->string('customer_address2', 255)->nullable()->change();
            $table->string('customer_phone', 255)->nullable()->change();
            $table->string('customer_email', 255)->nullable()->change();
            $table->string('customer_city', 255)->nullable()->change();
            $table->string('customer_province', 255)->nullable()->change();
            $table->string('payment_status', 255)->nullable()->change();
            $table->string('shipping_courier', 255)->nullable()->change();
            $table->string('shipping_number', 255)->nullable()->change();
            $table->string('voucher_code', 255)->nullable()->change();
        });

        Schema::table('shop_order_items', function (Blueprint $table) {
            $table->string('sku', 255)->change();
            $table->string('type', 255)->change();
            $table->string('name', 255)->change();
        });

        Schema::table('shop_payments', function (Blueprint $table) {
            $table->string('payment_type', 255)->change();
            $table->string('status', 255)->change();
        });

        Schema::table('shop_vouchers', function (Blueprint $table) {
            $table->string('code', 255)->change();
            $table->string('description', 255)->nullable()->change();
        });

        Schema::table('shop_product_images', function (Blueprint $table) {
            $table->string('name', 255)->nullable()->change();
        });

        Schema::table('shop_reviews', function (Blueprint $table) {
            $table->string('status', 255)->default('approved')->change();
        });
    }
};
