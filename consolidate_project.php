<?php

$dirs = ['app', 'config', 'database', 'routes', 'resources'];
$specificFiles = ['composer.json', 'bootstrap/app.php'];

$outputFile = 'ecommerce_hp_full_context.txt';
$handle = fopen($outputFile, 'w');

if (!$handle) {
    die("Could not open output file.\n");
}

function appendFile($path, $handle) {
    echo "Processing: $path\n";
    fwrite($handle, "\n" . str_repeat('=', 80) . "\n");
    fwrite($handle, "File: $path\n");
    fwrite($handle, str_repeat('=', 80) . "\n\n");
    fwrite($handle, file_get_contents($path) . "\n");
}

foreach ($specificFiles as $file) {
    if (file_exists($file)) {
        appendFile($file, $handle);
    }
}

foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $filename = $file->getFilename();
            // Include .php (covers .blade.php) and .json (for composer.json if inside, but we did that manually)
            // User asked for php and blade.
            if (str_ends_with($filename, '.php')) {
                 appendFile($file->getPathname(), $handle);
            }
        }
    }
}

fclose($handle);
echo "Done. Created $outputFile.\n";
echo "Size: " . round(filesize($outputFile) / 1024 / 1024, 2) . " MB\n";
