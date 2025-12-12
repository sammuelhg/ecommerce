<?php
// public/seed_now.php
// Script Dedicado para Popular o Banco (Seeder)

ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', 300);

echo "<h1>🌱 LosFit Seeder Force</h1>";
echo "<pre style='background: #f1f8e9; padding: 15px; border-radius: 5px;'>";

$rootDir = realpath(__DIR__ . '/..');
$phpBin = '/opt/alt/php84/usr/bin/php'; 

echo "Target: $rootDir\n";
echo "PHP: $phpBin\n";

// 1. Check if DB is migrated check?
// (Assumes tables exist)

// 2. Run Seeder
echo "\n--- Executing db:seed ---\n";
// Force flag is needed for production environment
$cmd = "$phpBin $rootDir/artisan db:seed --force --verbose 2>&1";
echo "Command: $cmd\n";
echo "---------------------------------------------------\n";
passthru($cmd);
echo "\n---------------------------------------------------\n";

echo "\nSEEDING COMPLETED.";
echo "</pre>";
?>
