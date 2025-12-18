<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rule = \App\Models\GridRule::where('position', 0)->first();
if ($rule) {
    echo "Rule at pos 0 exists: ID {$rule->id}, Type {$rule->type}\n";
    // Check if it's our newsletter card we failed to delete properly or re-created?
    // User said "didn't want me to delete". Maybe I already restored it? 
    // Or maybe the delete failed silently? The previous log said "deleted successfully".
    // Wait, did I run restore twice? No.
    // Maybe there was ANOTHER rule at position 0?
} else {
    echo "No rule at pos 0.\n";
}
