<?php
// public/install_v2.php
// Emergency Installer V2 - Forces MySQL Connection

ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', 300);

echo "<h1>🛠️ LosFit Installer V2</h1>";
echo "<pre style='background: #e0f7fa; padding: 15px; border-radius: 5px; color: #006064;'>";

$rootDir = realpath(__DIR__ . '/..');
$phpBin = '/opt/alt/php84/usr/bin/php'; 

echo "Root: $rootDir\n";

// 1. Setup Environment force
echo "\n--- [Step 1] Setting up MySQL Connection (.env) ---\n";
$envPath = $rootDir . '/.env';
$hostingerEnvPath = $rootDir . '/hostinger.env';

if (file_exists($hostingerEnvPath)) {
    if (copy($hostingerEnvPath, $envPath)) {
        echo "✅ Copied hostinger.env to .env\n";
    } else {
        echo "❌ Failed to copy hostinger.env\n";
    }
} else {
    echo "⚠️ hostinger.env missing!\n";
}

// Verify DB Connection String
$envContent = file_get_contents($envPath);
if (strpos($envContent, 'DB_CONNECTION=mysql') !== false) {
    echo "✅ Verified .env is using MySQL.\n";
} else {
    echo "❌ WARNING: .env might not be using mysql!\n";
}

// 2. Fix Permissions
echo "\n--- [Step 2] Fixing Permissions ---\n";
function recursiveChmod($path, $filePerm, $dirPerm) {
    if (!file_exists($path)) return;
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    if (is_dir($path)) chmod($path, $dirPerm);
    foreach ($iterator as $item) {
        chmod($item->getPathname(), $item->isDir() ? $dirPerm : $filePerm);
    }
}
recursiveChmod($rootDir, 0644, 0755);
if (file_exists($rootDir.'/storage')) recursiveChmod($rootDir.'/storage', 0666, 0777);
echo "✅ Permissions updated.\n";

// 3. Migrate
echo "\n--- [Step 3] Migrating Database (MySQL) ---\n";
// Clear config first to ensure getenv reads new .env
shell_exec("$phpBin $rootDir/artisan config:clear");

$cmd = "$phpBin $rootDir/artisan migrate:fresh --seed --force 2>&1";
echo "Command: $cmd\n";
echo "---------------------------------------------------\n";
passthru($cmd);
echo "\n---------------------------------------------------\n";

echo "\nCOMPLETED V2.";
echo "</pre>";
?>
