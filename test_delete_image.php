<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ProductImage;
use App\Services\ProductImageService;

// ID da imagem para testar (você pode mudar esse valor)
$imageId = 4; // Mude para o ID da imagem que quer testar
$productId = 78; // ID do produto

echo "=== Teste de Exclusão de Imagem ===\n\n";

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
echo "   Is Main: " . ($image->is_main ? 'Sim' : 'Não') . "\n";
echo "   Created: {$image->created_at}\n\n";

if ($image->product_id !== $productId) {
    echo "⚠️  AVISO: A imagem pertence ao produto #{$image->product_id}, mas você especificou produto #{$productId}\n";
    echo "Deseja continuar mesmo assim? (y/n): ";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if(trim($line) != 'y'){
        echo "Operação cancelada.\n";
        exit;
    }
}

echo "Tentando deletar através do ProductImageService...\n";

$service = app(ProductImageService::class);
$success = $service->deleteImage($imageId, $productId);

if ($success) {
    echo "✅ Imagem deletada com sucesso!\n";
    
    // Verificar se realmente foi deletada
    $checkImage = ProductImage::find($imageId);
    if (!$checkImage) {
        echo "✅ Confirmado: Imagem não existe mais no banco.\n";
    } else {
        echo "❌ ERRO: Imagem ainda existe no banco!\n";
    }
} else {
    echo "❌ Falha ao deletar imagem. Verifique os logs.\n";
}

echo "\n=== Fim do Teste ===\n";
