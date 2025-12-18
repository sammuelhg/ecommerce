<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductImageService;

// ID da imagem para definir como capa
$imageId = 5; // Mude para o ID da imagem que quer definir como capa
$productId = 78; // ID do produto

echo "=== Teste de Definir Imagem como Capa ===\n\n";

// Verificar se a imagem existe
$image = ProductImage::find($imageId);

if (!$image) {
    echo "❌ Imagem #{$imageId} não encontrada no banco de dados.\n";
    exit;
}

echo "✅ Imagem encontrada:\n";
echo "   ID: {$image->id}\n";
echo "   Product ID: {$image->product_id}\n";
echo "   Path: {$image->path}\n";
echo "   Is Main: " . ($image->is_main ? 'Sim' : 'Não') . "\n\n";

if ($image->product_id !== $productId) {
    echo "❌ ERRO: A imagem pertence ao produto #{$image->product_id}, mas você especificou produto #{$productId}\n";
    exit;
}

// Mostrar imagem principal atual
$product = Product::find($productId);
$currentMain = ProductImage::where('product_id', $productId)
    ->where('is_main', true)
    ->first();

if ($currentMain) {
    echo "📸 Imagem principal atual:\n";
    echo "   ID: {$currentMain->id}\n";
    echo "   Path: {$currentMain->path}\n\n";
} else {
    echo "⚠️  Produto não tem imagem principal definida.\n\n";
}

echo "Tentando definir imagem #{$imageId} como capa através do ProductImageService...\n";

$service = app(ProductImageService::class);
$success = $service->setMainImage($imageId, $productId);

if ($success) {
    echo "✅ Imagem definida como capa com sucesso!\n\n";
    
    // Verificar se realmente foi atualizada
    $image->refresh();
    $product->refresh();
    
    echo "📸 Nova imagem principal:\n";
    echo "   Imagem #{$imageId} is_main: " . ($image->is_main ? 'Sim' : 'Não') . "\n";
    echo "   Produto image path: {$product->image}\n";
    
    if ($image->is_main && $product->image === $image->path) {
        echo "✅ Confirmado: Imagem foi definida como capa corretamente!\n";
    } else {
        echo "❌ ERRO: Algo não está certo...\n";
    }
} else {
    echo "❌ Falha ao definir imagem como capa. Verifique os logs.\n";
}

echo "\n=== Fim do Teste ===\n";
