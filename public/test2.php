<?php
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap/app.php';
$app = app();
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$orders = Modules\Shop\Entities\Order::where('user_id', '52efba71-c4a7-4dcc-8698-235ac5985f19')->get();
foreach($orders as $order) {
    echo 'Order: ' . $order->code . "\n";
    foreach($order->items as $item) {
        $imgObj = $item->product ? $item->product->images->first() : null;
        echo '- Item: ' . $item->name . ' | URL: ' . shop_product_image($imgObj) . "\n";
    }
}
