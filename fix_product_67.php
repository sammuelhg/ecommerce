<?php

use App\Models\Product;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update product 67 name
$product = Product::with(['productType', 'productModel', 'productMaterial', 'productColor', 'productSize'])->find(67);

if ($product) {
    $parts = [];
    
    if ($product->productType) $parts[] = $product->productType->name;
    if ($product->productModel) $parts[] = $product->productModel->name;
    if ($product->productMaterial) $parts[] = "em {$product->productMaterial->name}";
    if ($product->attribute) $parts[] = $product->attribute;
    if ($product->productColor) $parts[] = "– {$product->productColor->name}";
    elseif ($product->color) $parts[] = "– {$product->color}";
    
    if ($product->productSize) $parts[] = "Tamanho {$product->productSize->name}";
    elseif ($product->size) $parts[] = "Tamanho {$product->size}";
    
    if (!empty($parts)) {
        $newName = ucwords(strtolower(implode(' ', $parts)));
        $newSlug = \Illuminate\Support\Str::slug($newName);
        
        echo "Product {$product->id}:\n";
        echo "  Old name: {$product->name}\n";
        echo "  New name: {$newName}\n";
        echo "  Old slug: {$product->slug}\n";
        echo "  New slug: {$newSlug}\n";
        
        $product->name = $newName;
        $product->slug = $newSlug;
        $product->save();
        
        echo "  ✓ Updated!\n";
    }
}
