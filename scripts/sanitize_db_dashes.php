<?php
// scripts/sanitize_db_dashes.php
// Replace En-dash (–) with Hyphen (-) to fix 'ÔÇô' display artifacts
// Run from: C:\xampp\htdocs\ecommerce\ecommerce-hp

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "--- Sanitizing Database Dashes ---\n";

// The En-dash specific bytes in UTF-8
$en_dash = "\xE2\x80\x93"; 
$hyphen = "-";

// Count before
$countQuery = DB::table('products')->where('name', 'LIKE', "%{$en_dash}%");
$count = $countQuery->count();

echo "Found $count products with En-dashes.\n";

if ($count > 0) {
    // We cannot easily use REPLACE() in SQL for mixed bytes depending on collation, 
    // so we iterate to be safe and explicit with PHP string manipulation.
    $products = $countQuery->select('id', 'name')->get();
    
    foreach ($products as $p) {
        $newName = str_replace($en_dash, $hyphen, $p->name);
        
        if ($newName !== $p->name) {
            DB::table('products')
                ->where('id', $p->id)
                ->update(['name' => $newName]);
                
            echo "Updated ID {$p->id}: {$p->name} -> {$newName}\n";
        }
    }
    echo "Sanitization Complete.\n";
} else {
    echo "Nothing to do.\n";
}
