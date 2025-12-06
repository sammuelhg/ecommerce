# Configuration
$serverUser = "u488238372"
$serverIp = "185.245.180.69"
$serverPort = "65002"
$remotePath = "~/domains/losfit.com.br/public_html" 
$archiveName = "deploy.tar.gz"

# Hostinger / CloudLinux specific path for PHP 8.2
$phpCmd = "/opt/alt/php82/usr/bin/php"
# Standard path for composer on Hostinger
$composerCmd = "/usr/local/bin/composer"

Write-Host "Starting deployment..." -ForegroundColor Cyan

# 1. Build Assets
Write-Host "1. Building assets..." -ForegroundColor Yellow
cmd /c "npm run build"

# 2. Create Archive
Write-Host "2. Creating archive ($archiveName)..." -ForegroundColor Yellow
if (Test-Path $archiveName) { Remove-Item $archiveName }

# Exclude vendor, node_modules, etc.
tar.exe -czvf $archiveName --exclude node_modules --exclude vendor --exclude .git --exclude .github --exclude .env --exclude $archiveName --exclude deploy.ps1 .

if (-not (Test-Path $archiveName)) { 
    Write-Error "Archive creation failed! deploy.tar.gz not found."
    exit 1 
}

# 3. Upload
Write-Host "3. Uploading archive (PASSWORD REQUIRED)..." -ForegroundColor Yellow
scp -P $serverPort $archiveName "${serverUser}@${serverIp}:~/"

if ($LASTEXITCODE -ne 0) { 
    Write-Error "Upload failed! Please check your password and connection."
    exit 1 
}

# 4. Remote Execution
Write-Host "4. Executing remote commands (PASSWORD REQUIRED)..." -ForegroundColor Yellow

$commands = @(
    "echo 'Creating directory...'",
    "mkdir -p $remotePath",
    "echo 'Extracting files...'",
    "tar -xzf ~/$archiveName -C $remotePath",
    "cd $remotePath",
    
    # Debug: Check if PHP exists
    "echo 'Checking PHP version...'",
    "$phpCmd -v",
    
    "echo 'Installing dependencies (using system composer with $phpCmd)...'",
    # Run system composer using the specific PHP version
    "$phpCmd $composerCmd install --no-dev --optimize-autoloader",
    
    "echo 'Running migrations...'",
    "$phpCmd artisan migrate --force",
    
    "echo 'Clearing caches...'",
    "$phpCmd artisan config:cache",
    "$phpCmd artisan route:cache",
    "$phpCmd artisan view:cache",
    
    "echo 'Cleaning up...'",
    "rm ~/$archiveName",
    "echo 'Deployment finished!'"
)

$remoteCommand = $commands -join " && "

ssh -p $serverPort "${serverUser}@${serverIp}" $remoteCommand
