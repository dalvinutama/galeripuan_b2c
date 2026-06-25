<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $images = DB::table('shop_product_images')->get();
    echo "Product images count: " . count($images) . "\n";
    $media = DB::table('media')->get();
    echo "Media count: " . count($media) . "\n";

    if(count($images) > 0) {
        $pImg = \Modules\Shop\Entities\ProductImage::first();
        echo "Image helper output: " . shop_product_image($pImg) . "\n";
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
