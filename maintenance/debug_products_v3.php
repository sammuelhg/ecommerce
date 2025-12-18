<?php

use App\Models\Product;
use App\Models\ProductSize;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ids = [65, 66];
$products = Product::whereIn('id', $ids)->get();

$output = "Products found: " . $products->count() . "\n";

foreach ($products as $product) {
    $output .= "--------------------------------\n";
    $output .= "ID: {$product->id}\n";
    $output .= "Name: {$product->name}\n";
    $output .= "Slug: {$product->slug}\n";
    $output .= "Model ID: {$product->product_model_id}\n";
    $output .= "Type ID: {$product->product_type_id}\n";
    $output .= "Color ID: {$product->product_color_id}\n";
    $output .= "Color String: {$product->color}\n";
    $output .= "Size ID: {$product->product_size_id}\n";
    $output .= "Size String: {$product->size}\n";
    
    if ($product->productSize) {
        $output .= "Relation Size Name: {$product->productSize->name}\n";
    } else {
        $output .= "Relation Size: NULL\n";
    }
}

$sizes = ProductSize::all();
$output .= "\nAll Sizes:\n";
foreach ($sizes as $size) {
    $output .= "ID: {$size->id} - Name: {$size->name}\n";
}

file_put_contents(__DIR__ . '/debug_output.txt', $output);
