<?php

use App\Models\Product;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$updated = Product::where('product_size_id', 2)->update(['size' => 'M']);

echo "Updated {$updated} products to size 'M'.\n";
