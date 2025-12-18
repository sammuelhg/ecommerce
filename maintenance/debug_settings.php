<?php

use App\Models\StoreSetting;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$settings = StoreSetting::all()->pluck('value', 'key');
echo "APP_URL from config: " . config('app.url') . "\n";
echo "Filesystem Public URL: " . config('filesystems.disks.public.url') . "\n";
echo "Store Logo in DB: " . ($settings['store_logo'] ?? 'NULL') . "\n";
echo "Profile Logo in DB: " . ($settings['profile_logo'] ?? 'NULL') . "\n";
