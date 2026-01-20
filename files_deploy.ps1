# Deploy somente arquivos alterados para Hostinger
$serverIp = "185.245.180.69"
$port = "65002"
$user = "u488238372"
$remotePath = "/home/$user/public_html"
$projectPath = Get-Location

# Lista de arquivos alterados/recentes
$filesToDeploy = @(
    "app\Http\Controllers\CartController.php",
    "app\Domains\Sales\Services\CartService.php",
    "public\js\shop-alpine.js",
    "resources\views\shop.blade.php",
    "resources\views\layouts\shop.blade.php",
    "resources\views\auth\login.blade.php",
    "resources\views\shop\partials\header.blade.php",
    "resources\views\shop\partials\search-bar.blade.php"
)

# Cria temp e compacta
$tempDir = Join-Path $projectPath "temp_partial_deploy"
if (Test-Path $tempDir) { Remove-Item -Path $tempDir -Recurse -Force -ErrorAction SilentlyContinue }
New-Item -ItemType Directory -Path $tempDir -Force | Out-Null

foreach ($file in $filesToDeploy) {
    $src = "$projectPath\$file"
    $dest = "$tempDir\$file"
    $parent = Split-Path $dest
    if (!(Test-Path $parent)) { New-Item -ItemType Directory -Path $parent -Force | Out-Null }
    Copy-Item -Path $src -Destination $dest -Force
}

$zipFile = "$projectPath\partial_deploy.zip"
if (Test-Path $zipFile) { Remove-Item -Path $zipFile -Force }
Compress-Archive -Path "$tempDir\*" -DestinationPath $zipFile -Force

Write-Host "Enviando partial_deploy.zip via SCP..." -ForegroundColor Cyan
# Usa scp com path relativo ao usuário se possível, ou absoluto
scp -P $port "$zipFile" "${user}@${serverIp}:${remotePath}/partial_deploy.zip"

Write-Host "Executando unzip no servidor..." -ForegroundColor Yellow
ssh -p $port "${user}@${serverIp}" "cd ${remotePath} && unzip -o partial_deploy.zip && rm partial_deploy.zip && php artisan view:clear"

# Limpeza
Remove-Item -Path $tempDir -Recurse -Force
Remove-Item -Path $zipFile -Force
Write-Host "Deploy Parcial Concluido!" -ForegroundColor Green
