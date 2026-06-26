<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoolifyDataSeeder extends Seeder
{
    public function run()
    {
        // Menghapus data lama terlebih dahulu agar tidak duplikat
        DB::table('shop_categories_products')->delete();
        DB::table('shop_product_inventories')->delete();
        DB::table('shop_product_images')->delete();
        DB::table('shop_products')->delete();
        DB::table('shop_categories')->delete();

        $categories = array (
);
        DB::table('shop_categories')->insert($categories);

        $products = array (
);
        foreach(array_chunk($products, 10) as $chunk) {
            DB::table('shop_products')->insert($chunk);
        }

        $product_images = array (
);
        foreach(array_chunk($product_images, 10) as $chunk) {
            DB::table('shop_product_images')->insert($chunk);
        }

        $product_inventories = array (
);
        foreach(array_chunk($product_inventories, 10) as $chunk) {
            DB::table('shop_product_inventories')->insert($chunk);
        }

        $categories_products = array (
);
        foreach(array_chunk($categories_products, 10) as $chunk) {
            DB::table('shop_categories_products')->insert($chunk);
        }

    }
}
