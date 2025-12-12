<?php
// public/install.php
// Emergency Installer for Hostinger (Bypassing SSH)

ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', 300); // 5 minutes

echo "<h1>🛠️ LosFit Emergency Installer</h1>";
echo "<pre style='background: #f4f4f4; padding: 15px; border-radius: 5px;'>";

// 1. Define Paths & Variables
$rootDir = realpath(__DIR__ . '/..');
$phpBin = '/opt/alt/php84/usr/bin/php'; // Default Hostinger PHP 8.4 path

echo "Root Dir: $rootDir\n";
echo "PHP Bin: $phpBin\n";

// Function to recursively chmod
function recursiveChmod($path, $filePerm, $dirPerm) {
    if (!file_exists($path)) return;
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    // Fix root dir first
    if (is_dir($path)) chmod($path, $dirPerm);
    
    foreach ($iterator as $item) {
        if ($item->isDir()) {
            chmod($item->getPathname(), $dirPerm);
        } else {
            chmod($item->getPathname(), $filePerm);
        }
    }
}

// 2. Fix Permissions
echo "\n--- [Step 1] Fixing Permissions ---\n";
try {
    echo "Setting 755/644 for base files...\n";
    recursiveChmod($rootDir, 0644, 0755);
    
    echo "Setting 777 for storage...\n";
    $storagePath = $rootDir . '/storage';
    if (file_exists($storagePath)) {
        recursiveChmod($storagePath, 0666, 0777); 
    }
    
    $cachePath = $rootDir . '/bootstrap/cache';
    if (file_exists($cachePath)) {
        chmod($cachePath, 0777);
    }
    echo "✅ Permissions Fixed.\n";
} catch (Exception $e) {
    echo "❌ Error fixing permissions: " . $e->getMessage() . "\n";
}

// 3. Run Migrations via Process/Shell
echo "\n--- [Step 2] Running Database Migrations ---\n";

if (!file_exists("$rootDir/artisan")) {
    echo "❌ CRITICAL: 'artisan' file not found in root. Deployment might be incomplete.\n";
} else {
    // Try Command 1: Migrate Fresh + Seed
    $cmd = "$phpBin $rootDir/artisan migrate:fresh --seed --force 2>&1";
    echo "Executing: $cmd\n";
    $output = shell_exec($cmd);
    echo "Output:\n" . ($output ?: 'No output (Command might have failed silently or shell_exec is disabled)') . "\n";
    
    if (strpos($output, 'successfully') !== false) {
        echo "✅ Migrations Success!\n";
    }
    
    // Try Command 2: Optimize
    echo "\nRunning Optimizations...\n";
    shell_exec("$phpBin $rootDir/artisan optimize:clear 2>&1");
    shell_exec("$phpBin $rootDir/artisan storage:link 2>&1");
}

echo "\n--- INSTALLATION ATTEMPT FINISHED ---\n";
echo "If you see errors above, please copy and share them.";
echo "</pre>";
?>
