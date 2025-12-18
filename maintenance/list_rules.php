<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rules = \App\Models\GridRule::all();
echo "Total Rules: " . $rules->count() . "\n";
foreach($rules as $rule) {
    echo "ID: {$rule->id} | Pos: {$rule->position} | Type: {$rule->type} | Config: " . json_encode($rule->configuration) . "\n";
}
