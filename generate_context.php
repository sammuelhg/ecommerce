<?php

// Configuration
$allowedExtensions = ['php', 'blade.php', 'js', 'css', 'json', 'yml', 'yaml', 'md', 'html'];
$ignoredDirectories = [
    'vendor', 
    'node_modules', 
    'storage', 
    'public', 
    '.git', 
    '.idea', 
    '.vscode',
    'tests' // Optional, but usually not "core architecture" unless requested
];
$directoriesToScan = [
    'app',
    'routes',
    'config',
    'database',
    'resources/views',
    'resources/js',
    'resources/css'
];

$outputFile = 'project_context_analysis.txt';

// Helper to check if file is text
function isTextFile($path) {
    return !in_array(pathinfo($path, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'webp', 'ico', 'zip', 'phar', 'lock']);
}

// 1. Generate Tree Structure
echo "Generating file structure...\n";
$structure = "";

function scanStructure($dir, $prefix = '') {
    global $ignoredDirectories, $allowedExtensions;
    $result = "";
    
    $files = scandir($dir);
    
    // Filter out . and ..
    $files = array_filter($files, function($f) { return !in_array($f, ['.', '..']); });
    
    // Convert to array and reset keys
    $files = array_values($files);
    $count = count($files);
    
    foreach ($files as $index => $file) {
        $path = $dir . '/' . $file;
        $isLast = ($index === $count - 1);
        $connector = $isLast ? '└── ' : '├── ';
        
        if (is_dir($path)) {
            if (in_array($file, $ignoredDirectories)) continue;
            
            $result .= $prefix . $connector . $file . "/\n";
            $result .= scanStructure($path, $prefix . ($isLast ? '    ' : '│   '));
        } else {
            // Check extension
            // $ext = pathinfo($file, PATHINFO_EXTENSION);
            // if (!in_array($ext, $allowedExtensions)) continue; // Show all in tree? Or filter? Let's show all in tree but filter content
            
            $result .= $prefix . $connector . $file . "\n";
        }
    }
    return $result;
}

// Generate structure only for allowed root dirs
foreach ($directoriesToScan as $dir) {
    if (is_dir($dir)) {
        $structure .= $dir . "/\n";
        $structure .= scanStructure($dir, "    ");
    }
}

// 2. Concatenate Content
echo "Concatenating content...\n";
$contentStr = "";

function scanContent($dir) {
    global $ignoredDirectories, $allowedExtensions;
    $data = "";
    
    $files = scandir($dir);
    $files = array_filter($files, function($f) { return !in_array($f, ['.', '..']); });
    
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            if (in_array($file, $ignoredDirectories)) continue;
            $data .= scanContent($path);
        } else {
            // Filter by extension for content
            // Simple check: is it in a relevant folder?
            // Actually, we are only recursing into allowed folders from root call
            // But verify binary
            if (!isTextFile($path)) continue;
            
            $data .= str_repeat("=", 50) . "\n";
            $data .= "FILE: " . $path . "\n";
            $data .= str_repeat("=", 50) . "\n";
            $data .= file_get_contents($path) . "\n\n";
        }
    }
    return $data;
}

foreach ($directoriesToScan as $dir) {
    if (is_dir($dir)) {
        $contentStr .= scanContent($dir);
    }
}

// Include specific root files if needed
$rootFiles = ['composer.json', 'package.json', 'vite.config.js'];
foreach ($rootFiles as $file) {
    if (file_exists($file)) {
        $contentStr .= str_repeat("=", 50) . "\n";
        $contentStr .= "FILE: " . $file . "\n";
        $contentStr .= str_repeat("=", 50) . "\n";
        $contentStr .= file_get_contents($file) . "\n\n";
    }
}

// Write Final Output
$finalOutput = "PROJECT STRUCTURE:\n" . str_repeat("-", 20) . "\n" . $structure . "\n\n" . "FILE CONTENTS:\n" . str_repeat("-", 20) . "\n\n" . $contentStr;

file_put_contents($outputFile, $finalOutput);
echo "Context generated at: " . realpath($outputFile);
