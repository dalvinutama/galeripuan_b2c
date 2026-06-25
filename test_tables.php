<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $tables = DB::select('SHOW TABLES');
    echo "=== DATABASE TABLES ===\n";
    foreach($tables as $table) {
        $vars = get_object_vars($table);
        $tableName = array_values($vars)[0];
        $count = DB::table($tableName)->count();
        echo $tableName . " (" . $count . " rows)\n";
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
