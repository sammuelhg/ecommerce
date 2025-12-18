<?php

use App\Models\Category;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$categories = Category::all();

echo "Categorias no banco:\n";
foreach ($categories as $cat) {
    $normalized = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', trim($cat->name)));
    echo "ID: {$cat->id} | Nome: {$cat->name} | Slug: {$cat->slug} | Normalizado: {$normalized}\n";
}
