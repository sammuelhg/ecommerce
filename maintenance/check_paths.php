<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = \App\Models\Product::whereNotNull('image')->take(5)->get();

echo "\n--- Verificando Caminhos das Imagens ---\n";
foreach ($products as $p) {
    echo "ID: {$p->id} | Image: {$p->image}\n";
}

$absoluteCount = \App\Models\Product::where('image', 'LIKE', 'http%')->count();
echo "\nTotal de imagens com URL absoluta (http...): $absoluteCount\n";
echo "Total de imagens relativas: " . (\App\Models\Product::whereNotNull('image')->count() - $absoluteCount) . "\n";
?>
