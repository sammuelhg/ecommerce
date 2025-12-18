<?php

use App\Models\User;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = User::count();
$first = User::first();

echo "Total Users: " . $count . "\n";
if ($first) {
    echo "First User ID: " . $first->id . "\n";
} else {
    echo "No users found.\n";
}
