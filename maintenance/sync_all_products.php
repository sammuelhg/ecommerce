<?php

use App\Models\Product;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = Product::with(['productSize', 'productColor'])->get();

$updated = 0;

foreach ($products as $product) {
    $needsUpdate = false;
    
    // Sync size
    if ($product->product_size_id && $product->productSize) {
        $correctSize = $product->productSize->name;
        if ($product->size !== $correctSize) {
            $product->size = $correctSize;
            $needsUpdate = true;
            echo "Product {$product->id}: Updated size from '{$product->getOriginal('size')}' to '{$correctSize}'\n";
        }
    }
    
    // Sync color
    if ($product->product_color_id && $product->productColor) {
        $correctColor = $product->productColor->name;
        if ($product->color !== $correctColor) {
            $product->color = $correctColor;
            $needsUpdate = true;
            echo "Product {$product->id}: Updated color from '{$product->getOriginal('color')}' to '{$correctColor}'\n";
        }
    }
    
    if ($needsUpdate) {
        $product->save();
        $updated++;
    }
}

echo "\nTotal products updated: {$updated}\n";
