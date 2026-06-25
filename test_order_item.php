<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
try {
    $items = DB::table('shop_order_items')->get();
    foreach($items as $item) {
        echo "Order Item: " . $item->id . "\n";
        echo "Product ID: " . $item->product_id . "\n";
        $p = \Modules\Shop\Entities\Product::find($item->product_id);
        if($p) {
            echo "Product found: " . $p->name . "\n";
            echo "Parent ID: " . $p->parent_id . "\n";
            $parentProduct = $p->parent_id ? $p->parent : null;
            $productImageObj = $p->images->first() ?? ($parentProduct ? $parentProduct->images->first() : null);
            if ($productImageObj) {
                echo "Image object found: " . $productImageObj->id . "\n";
                echo "Image URL: " . shop_product_image($productImageObj) . "\n";
            } else {
                echo "Image object NOT found. Fallback to default.\n";
            }
        } else {
            echo "Product NOT FOUND\n";
        }
    }
} catch (\Throwable $e) {}
