<?php

use App\Services\SkuGeneratorService;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$skuService = new SkuGeneratorService();

// Testar várias categorias
$testCategories = [
    'ModaFit',
    'ModaPraia',
    'ModaCrochê',
    'Suplementos',
    'LosfitNutri'
];

foreach ($testCategories as $cat) {
    $sku = $skuService->generate($cat, 'Whey Protein', 'Cinza', 'G');
    echo "Categoria: {$cat} → SKU: {$sku}\n";
}
