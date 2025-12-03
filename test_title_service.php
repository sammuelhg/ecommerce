<?php

use App\Services\ProductTitleService;
use App\Models\ProductType;
use App\Models\ProductModel;
use App\Models\ProductMaterial;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = new ProductTitleService();

// Mock data - assuming these IDs exist in your DB based on previous logs
// Type: 3 (Calça), Model: 11 (Skinny), Material: 10 (Elastano)
$typeId = 3;
$modelId = 11;
$materialId = 10;
$color = 'Azul';
$size = 'M';
$attribute = 'Rasgada';

echo "Testing ProductTitleService...\n";

$title = $service->generateTitle($typeId, $modelId, $materialId, $attribute, $color, $size);

echo "Generated Title: " . $title . "\n";

if (empty($title)) {
    echo "ERROR: Title is empty!\n";
} else {
    echo "SUCCESS: Title generated.\n";
}
