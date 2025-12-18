<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$logFile = 'test_result.txt';
file_put_contents($logFile, "Starting Test\n");

try {
    file_put_contents($logFile, "Testing Action...\n", FILE_APPEND);
    $action = new App\Actions\Shop\ListStoreFrontProductsAction();
    $products = $action->execute(10);
    file_put_contents($logFile, "Products found: " . $products->count() . "\n", FILE_APPEND);

    file_put_contents($logFile, "Testing Composer Merge...\n", FILE_APPEND);
    $composer = new App\Services\GridComposer();
    $grid = $composer->merge($products, [], false);
    file_put_contents($logFile, "Grid items: " . $grid->count() . "\n", FILE_APPEND);
    
    file_put_contents($logFile, "SUCCESS\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents($logFile, "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n", FILE_APPEND);
}
