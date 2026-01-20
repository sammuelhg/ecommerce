<?php
// scripts/fix_hostinger_encoding.php
// ROBUST Production Encoding & Content Fixer
// Can be run via SSH/Deploy to fix existing data without re-importing

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== STARTING PRODUCTION DATABASE REPAIR ===\n";

// Tables to check
$tables = ['products', 'campaigns'];
$columns = ['name', 'description', 'email_content_body'];

foreach ($tables as $tbl) {
    if (!DB::schema()->hasTable($tbl)) continue;

    echo "Processing table '$tbl'...\n";
    
    // Get columns that exist
    $valid_cols = [];
    foreach ($columns as $col) {
        if (DB::schema()->hasColumn($tbl, $col)) {
            $valid_cols[] = $col;
        }
    }

    DB::table($tbl)->orderBy('id')->chunk(50, function ($rows) use ($tbl, $valid_cols) {
        foreach ($rows as $row) {
            $updates = [];
            foreach ($valid_cols as $col) {
                $val = $row->{$col};
                if (!$val) continue;

                $original = $val;
                $fixed = $val;

                // 1. Fix Mojibake (Double Encoded UTF-8)
                // Check for common artifacts like "Ãª" or "Ã£"
                if (preg_match('/[\xc2-\xdf][\x80-\xbf]/', $fixed)) {
                    // Try to reverse double-encoding
                    // Convert from UTF-8 to CP1252 (bytes), then back to UTF-8
                    // e.g. "Ãª" (C3 AA) -> bytes C3 AA -> interpret as "ê"
                    $attempt = @mb_convert_encoding($fixed, 'CP1252', 'UTF-8');
                    // Check if the result is valid UTF-8
                    if ($attempt && mb_check_encoding($attempt, 'UTF-8')) {
                        // Validate heuristic: "ModaCrochÃª" -> "ModaCrochê"
                        if (strpos($fixed, 'ModaCrochÃª') !== false && strpos($attempt, 'ModaCrochê') !== false) {
                             $fixed = $attempt;
                        }
                        // Broader check: if length reduced considerably (char count), it's likely a fix
                        // "Ãª" is 2 chars, "ê" is 1 char.
                        else if (mb_strlen($attempt) < mb_strlen($fixed)) {
                             // Be conservative: only apply if we see known artifacts
                             if (strpos($fixed, 'Ã') !== false) {
                                  $fixed = $attempt;
                             }
                        }
                    }
                }

                // 2. Fix Replacement Character (U+FFFD) artifacts
                // "\xEF\xBF\xBD"
                if (strpos($fixed, "\xEF\xBF\xBD") !== false) {
                     $fixed = str_replace("\xEF\xBF\xBD", ' - ', $fixed);
                }

                // 3. Fix "Macramê  Branco" and other Dash patterns
                // Double space where dash should be
                if (strpos($fixed, 'Macramê  Branco') !== false) {
                    $fixed = str_replace('Macramê  Branco', 'Macramê - Branco', $fixed);
                }
                
                // Fix "Legging... Brilhe  Verde" pattern
                // Generic: "Word  Word" -> "Word - Word"
                // Match space-RepChar-space
                $fixed = str_replace(" \xEF\xBF\xBD ", ' - ', $fixed);
                
                // 4. Fix "Tamanho nico" -> "Tamanho Único"
                // Pattern: "Tamanho nico"
                $fixed = str_replace('Tamanho ' . "\xEF\xBF\xBD" . 'nico', 'Tamanho Único', $fixed);
                
                // Fallback for just "nico" if needed
                $fixed = str_replace("\xEF\xBF\xBD" . 'nico', 'Único', $fixed);

                if ($fixed !== $original) {
                    $updates[$col] = $fixed;
                }
            }

            if (!empty($updates)) {
                DB::table($tbl)->where('id', $row->id)->update($updates);
                echo "   Fixed ID {$row->id}\n";
            }
        }
    });
}

echo "=== REPAIR COMPLETE ===\n";
