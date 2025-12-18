<?php

use App\Models\Form;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$forms = Form::all();

echo "Total Forms: " . $forms->count() . "\n";
foreach ($forms as $form) {
    echo "ID: " . $form->id . " | Title: " . $form->title . " | Slug: " . ($form->slug ?? 'NULL') . " | Active: " . $form->is_active . "\n";
}
