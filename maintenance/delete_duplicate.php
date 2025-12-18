<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Delete the duplicate rule at position 1
\App\Models\GridRule::destroy(29);
echo "Deleted Rule ID 29.";
