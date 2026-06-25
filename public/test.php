<?php
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap/app.php';
$app = app();
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$order = Modules\Shop\Entities\Order::where('code', 'INV-1779507104')->first();
$item = $order->items->first();
$productImage = $item->product->images->first();

echo "Product Image Object ID: " . $productImage->id . "\n";
$mediaCount = $productImage->getMedia('products')->count();
echo "Media Count: " . $mediaCount . "\n";

echo "Function result: " . shop_product_image($productImage) . "\n";
