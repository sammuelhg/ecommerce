<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = 26;
$rule = \App\Models\GridRule::find($id);
if ($rule) {
    if ($rule->delete()) {
        echo "Rule ID {$id} deleted successfully.\n";
    } else {
        echo "Failed to delete Rule ID {$id}.\n";
    }
} else {
    echo "Rule ID {$id} not found.\n";
}
