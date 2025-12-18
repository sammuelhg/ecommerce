<?php

use App\Models\Product;
use App\Models\ProductSize;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = Product::where('name', 'LIKE', '%Whey%')->get();

echo "Products found: " . $products->count() . "\n";

foreach ($products as $product) {
    echo "--------------------------------\n";
    echo "ID: {$product->id}\n";
    echo "Name: {$product->name}\n";
    echo "Slug: {$product->slug}\n";
    echo "Model ID: {$product->product_model_id}\n";
    echo "Type ID: {$product->product_type_id}\n";
    echo "Color ID: {$product->product_color_id}\n";
    echo "Color String: {$product->color}\n";
    echo "Size ID: {$product->product_size_id}\n";
    echo "Size String: {$product->size}\n";
    
    if ($product->productSize) {
        echo "Relation Size Name: {$product->productSize->name}\n";
    } else {
        echo "Relation Size: NULL\n";
    }
}

$sizes = ProductSize::all();
echo "\nAll Sizes:\n";
foreach ($sizes as $size) {
    echo "ID: {$size->id} - Name: {$size->name}\n";
}
