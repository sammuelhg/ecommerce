<?php

use App\Models\Product;
use App\Models\ProductSize;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Based on the previous finding: Model ID 56, Type ID 45
$siblings = Product::where('product_model_id', 56)
            ->where('product_type_id', 45)
            ->with(['productSize'])
            ->get();

$output = "Siblings found: " . $siblings->count() . "\n";

foreach ($siblings as $product) {
    $output .= "--------------------------------\n";
    $output .= "ID: {$product->id}\n";
    $output .= "Name: {$product->name}\n";
    $output .= "Size ID: {$product->product_size_id}\n";
    $output .= "Size String: {$product->size}\n";
    
    if ($product->productSize) {
        $output .= "Relation Size Name: {$product->productSize->name}\n";
    } else {
        $output .= "Relation Size: NULL\n";
    }
}

file_put_contents(__DIR__ . '/debug_siblings.txt', $output);
