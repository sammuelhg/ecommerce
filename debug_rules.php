<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rules = \App\Models\GridRule::all();
echo "Found " . $rules->count() . " rules:\n";
foreach($rules as $rule) {
    echo "ID: {$rule->id} | Position: {$rule->position} | Type: {$rule->type} | Active: {$rule->is_active}\n";
}
