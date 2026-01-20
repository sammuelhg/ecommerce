<?php
// scripts/diagnose_db_encoding.php
// Run this from the project root: php scripts/diagnose_db_encoding.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "--- Encoding Diagnostic ---\n";

// Fetch products with likely corrupted chars
// 'ÔÇô' is a common artifact for en-dash
$products = DB::table('products')
    ->select('id', 'name')
    ->where('id', 81)
    ->get();

if ($products->isEmpty()) {
    echo "Product 'Saia Longo Em Viscose' NOT FOUND.\n";
    // Search broadly
    $products = DB::table('products')->where('name', 'LIKE', '%Saia%')->limit(5)->get();
}

foreach ($products as $p) {
    echo "ID: {$p->id}\n";
    echo "Current: " . $p->name . "\n";
    echo "Hex: " . bin2hex($p->name) . "\n";
    
    // Check if it contains the Utf-8 bytes for En-dash (E2 80 93)
    if (strpos($p->name, "\xE2\x80\x93") !== false) {
        echo "Contains UTF-8 En-dash (E2 80 93)\n";
    }
    // Check if it contains UTF-8 for ÔÇô (C3 94 C3 87 C3 B4)
    if (strpos($p->name, "\xC3\x94\xC3\x87\xC3\xB4") !== false) {
        echo "Contains UTF-8 for 'ÔÇô' (C3 94 C3 87 C3 B4) - MOJIBAKE DETECTED!\n";
        
        $fixed = iconv('UTF-8', 'CP850//IGNORE', $p->name);
        echo "Attempted Fix (UTF-8 -> CP850): $fixed\n";
    }

    echo "---------------------------\n";
}

if ($products->isEmpty()) {
    echo "No obvious CP850 corruption artifacts (ÔÇô) found in the first 10 matches. trying generic listing.\n";
    $products = DB::table('products')->limit(5)->get();
}

foreach ($products as $p) {
    echo "ID: {$p->id}\n";
    echo "Current: " . $p->name . "\n";
    
    // Attempt Fix: UTF-8 -> CP850
    // This assumes the characters currently visible (e.g. Ô) are what was "read" from the original bytes using CP850
    $fixed = @iconv('UTF-8', 'CP850//IGNORE', $p->name);
    
    echo "Fixed (CP850): " . $fixed . "\n";
    echo "---------------------------\n";
}
