<?php
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap/app.php';
$app = app();
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$prods = Modules\Shop\Entities\Product::all();
foreach($prods as $p) {
    echo $p->name . ' - images: ' . $p->images->count() . "\n";
}
