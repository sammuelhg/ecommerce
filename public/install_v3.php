<?php
// public/install_v3.php
// Emergency Installer V3 - The "Hammer" Edition
// 1. Force Create .env
// 2. Clear Config
// 3. Migrate MySQL

ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', 300);

echo "<h1>🛠️ LosFit Installer V3</h1>";
echo "<pre style='background: #e8f5e9; padding: 15px; border-radius: 5px; color: #1b5e20;'>";

$rootDir = realpath(__DIR__ . '/..');
$phpBin = '/opt/alt/php84/usr/bin/php'; 

echo "Target Directory: $rootDir\n";
echo "(Confirming this is valid: .../domains/losfit.com.br/public_html)\n";

// 1. FORCE WRITE .ENV CONTENT
echo "\n--- [Step 1] Force Creating .env (MySQL Config) ---\n";
$envPath = $rootDir . '/.env';

// CREDENCIAIS FIXAS (Da sua conta Hostinger)
$envContent = <<<'EOD'
APP_NAME=LosFit
APP_ENV=production
APP_KEY=base64:Z4v05feP+qEppVkYLC9CNnqAlpcq489h9KQtdn2icIM=
APP_DEBUG=true
APP_URL=https://losfit.com.br

LOG_CHANNEL=stack
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u488238372_losfit
DB_USERNAME=u488238372_losfit
DB_PASSWORD=!Sa002125

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=contato@losfit.com.br
MAIL_PASSWORD=!Sa002125
MAIL_ENCRYPTION=ssl
EOD;

if (file_put_contents($envPath, $envContent)) {
    echo "✅ .env created successfully with MySQL credentials.\n";
} else {
    echo "❌ Failed to create .env file (Permissions?)\n";
}

// 2. Fix Permissions & Create Directories
echo "\n--- [Step 2] Creating Directories & Fixing Permissions ---\n";

$requiredDirs = [
    $rootDir . '/storage/framework/sessions',
    $rootDir . '/storage/framework/views',
    $rootDir . '/storage/framework/cache',
    $rootDir . '/storage/logs',
    $rootDir . '/bootstrap/cache',
];

foreach ($requiredDirs as $dir) {
    if (!file_exists($dir)) {
        if (mkdir($dir, 0777, true)) {
            echo "✅ Created missing directory: $dir\n";
        } else {
            echo "❌ Failed to create directory: $dir\n";
        }
    }
}

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
// Clear config is CRITICAL here to load the new .env
shell_exec("$phpBin $rootDir/artisan config:clear");

$cmd = "$phpBin $rootDir/artisan migrate:fresh --seed --force 2>&1";
echo "Command: $cmd\n";
echo "---------------------------------------------------\n";
passthru($cmd);
echo "\n---------------------------------------------------\n";

echo "\nCOMPLETED V3.";
echo "</pre>";
?>
