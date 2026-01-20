<?php
// scripts/fix_hostinger_encoding.php
// Fixes "CP850 interpreted as UTF-8" artifacts (Mojibake) in Production DB
// artifacts: ÔÇô (–), ├¬ (ê), ├ú (ã), etc.

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "--- Starting Production Encoding Repair ---\n";

// Fetch all products (chunked to save memory)
DB::table('products')->orderBy('id')->chunk(50, function ($products) {
    foreach ($products as $p) {
        $original = $p->name;
        $fixed = $original;
        $needsUpdate = false;

        // Detect common artifacts: 
        // ├ (C3 in CP850 -> start of many UTF-8 2-byte seqs like Ã, ê, í...)
        // ÔÇô (En-dash)
        if (strpos($original, 'ÔÇô') !== false || strpos($original, '├') !== false || strpos($original, 'Ã') !== false) {
             // Attempt standard repair: Treat current UTF-8 string as if it were CP850 bytes
             $attempt = @iconv('UTF-8', 'CP850//IGNORE', $original);
             
             if ($attempt && strlen($attempt) < strlen($original)) {
                 // Heuristic: If it got shorter and looks cleaner, it's likely the fix.
                 // Also specific check for known broken strings
                 if (strpos($original, 'ModaCroch├¬') !== false) {
                     $fixed = str_replace('ModaCroch├¬', 'ModaCrochê', $original); // Safe manual replacement for brand
                     $needsUpdate = true;
                 } else {
                     $fixed = $attempt;
                     $needsUpdate = true;
                 }
             }
        }
        
        // Also apply the En-dash to Hyphen sanitization (User liked this locally)
        // Repairing 'ÔÇô' via iconv gives '–' (En-dash). We might want '-' (Hyphen).
        if ($needsUpdate && strpos($fixed, '–') !== false) {
             $fixed = str_replace('–', '-', $fixed);
        } elseif (strpos($fixed, '–') !== false) {
             // Even if encoding was fine, replace En-dash with Hyphen for consistency
             $fixed = str_replace('–', '-', $fixed);
             $needsUpdate = true;
        }

        // Apply Update
        if ($needsUpdate && $fixed !== $original) {
            DB::table('products')
                ->where('id', $p->id)
                ->update([
                    'name' => $fixed,
                    // We should also fix description/slug if needed, but name is priority 1
                ]);
            echo "Fixed ID {$p->id}: $original -> $fixed\n";
        }
    }
});

echo "--- Repair Complete ---\n";
