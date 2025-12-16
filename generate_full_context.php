<?php

$outputFile = __DIR__ . '/contexto_completo_sistema.txt';
$rootPath = __DIR__;

$excludeDirs = [
    'vendor',
    'node_modules',
    '.git',
    'storage',
    'public', // Usually built assets, source is in resources. If using standard laravel, index.php is here but simple.
    '.idea',
    '.vscode',
    '.github',
    'deploy_versions',
    'build'
];

$allowedExtensions = [
    'php',
    'blade.php',
    'js',
    'css',
    'json',
    'md',
    'sql',     // database schemas
    'xml',     // phpunit.xml
    'yaml',
    'yml',
    'stub'     // stub files
];

$filesToAlwaysInclude = [
    '.env.example',
    'composer.json',
    'package.json',
    'vite.config.js',
    'phpunit.xml',
    'artisan'
];

// Helper to check extensions
function hasAllowedExtension($filename, $allowedExtensions) {
    // Check specific blade.php first
    if (str_ends_with($filename, '.blade.php')) return true;
    
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return in_array($ext, $allowedExtensions);
}

function str_ends_with_poly($haystack, $needle) {
    $length = strlen($needle);
    if (!$length) return true;
    return substr($haystack, -$length) === $needle;
}

// 1. Generate Tree
echo "Generating Project Map...\n";
$treeLines = [];

function buildTree($dir, $prefix, &$lines) {
    global $excludeDirs;
    $items = scandir($dir);
    if ($items === false) return;
    $items = array_diff($items, ['.', '..']);
    
    // Filter
    $validItems = [];
    foreach ($items as $item) {
        if (in_array($item, $excludeDirs)) continue;
        $validItems[] = $item;
    }

    $count = count($validItems);
    $i = 0;
    foreach ($validItems as $item) {
        $i++;
        $isLast = $i === $count;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        $connector = $isLast ? '└── ' : '├── ';
        
        $lines[] = $prefix . $connector . $item;
        
        if (is_dir($path)) {
            buildTree($path, $prefix . ($isLast ? '    ' : '│   '), $lines);
        }
    }
}
buildTree($rootPath, '', $treeLines);
$fullTree = implode("\n", $treeLines);


// 2. Generate Content
echo "Collecting Content...\n";
$contentOutput = "";

function scanAndCollect($dir) {
    global $excludeDirs, $allowedExtensions, $filesToAlwaysInclude, $contentOutput, $rootPath;
    
    $items = scandir($dir);
    if ($items === false) return;
    $items = array_diff($items, ['.', '..']);

    foreach ($items as $item) {
        if (in_array($item, $excludeDirs)) continue;

        $path = $dir . DIRECTORY_SEPARATOR . $item;
        
        if (is_dir($path)) {
            scanAndCollect($path);
        } else {
            // Check if we should include this file
            $shouldInclude = hasAllowedExtension($item, $allowedExtensions) || in_array($item, $filesToAlwaysInclude);

            // Skip large files (e.g. > 1MB)
            if ($shouldInclude && filesize($path) > 1024 * 1024) {
                 $shouldInclude = false; 
            }
            // Skip this script, the output file, and previous large context files
            if (str_contains($item, 'contexto_completo') || str_contains($item, 'context_analysis') || $item === basename(__FILE__)) {
                $shouldInclude = false;
            }
            // Skip binary-like files just in case (e.g. .min.js if we wanted, but let's keep them for now)
            if (str_ends_with_poly($item, '.min.js') || str_ends_with_poly($item, '.min.css')) {
                 // Maybe exclude minified? Let's exclude to save space
                 $shouldInclude = false;
            }

            if ($shouldInclude) {
                // Formatting
                $relPath = str_replace($rootPath . DIRECTORY_SEPARATOR, '', $path);
                
                // Read content
                $content = file_get_contents($path);
                // Check for binary
                if (preg_match('/[\x00-\x08\x0E-\x1F\x7F]/', substr($content, 0, 512))) {
                    // Likely binary
                    continue;
                }

                $contentOutput .= str_repeat("=", 80) . "\n";
                $contentOutput .= "FILE: " . $relPath . "\n";
                $contentOutput .= str_repeat("=", 80) . "\n";
                $contentOutput .= $content . "\n\n";
            }
        }
    }
}

scanAndCollect($rootPath);

// Write File
$finalContent = "PROJECT CONTEXT EXPORT\n";
$finalContent .= "Generated: " . date('Y-m-d H:i:s') . "\n\n";
$finalContent .= "PROJECT STRUCTURE:\n";
$finalContent .= str_repeat("-", 40) . "\n";
$finalContent .= $fullTree . "\n\n";
$finalContent .= "FILE CONTENTS:\n";
$finalContent .= str_repeat("-", 40) . "\n";
$finalContent .= $contentOutput;

file_put_contents($outputFile, $finalContent);

echo "Success! Context written to: " . $outputFile . "\n";
?>
