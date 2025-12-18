<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Re-create the rule
// Assuming standard configuration. 
// Ideally I'd use the original configuration but I don't have it saved. 
// But "newsletter_form" usually implies a specific form_id or default.
// Let's create it and if it needs specific form_id, well, it was ID 26.
// Let's try to find an active form first to bind? Or just default.

$rule = new \App\Models\GridRule();
$rule->position = 0;
$rule->type = 'card.newsletter_form';
$rule->col_span = 1;
$rule->is_active = true;
$rule->configuration = [
    'title' => '📧 Newsletter',
    'text' => 'Ganhe <strong class="text-danger">15% OFF</strong> na 1ª compra!',
    'bg_color' => 'bg-white',
    // We need a form_id. Let's pick the first active form (e.g. ID 2 from logs).
    'form_id' => 2 
];
$rule->form_id = 2; // Also set column if exists
$rule->save();

echo "Rule restored with ID: " . $rule->id . "\n";
