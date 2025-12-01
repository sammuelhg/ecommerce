<?php

use App\Models\Category;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$categories = Category::all();

echo "List of Categories:\n";
foreach ($categories as $category) {
    echo "ID: {$category->id} | Name: {$category->name} | Slug: {$category->slug}\n";
}
