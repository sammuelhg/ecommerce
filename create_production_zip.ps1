# Script para criar pacote de produção para losfit.com.br
# Este script cria um arquivo .zip com apenas os arquivos necessários para produção

$projectPath = "c:\xampp\htdocs\ecommerce\ecommerce-hp"
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$outputZip = "c:\xampp\htdocs\ecommerce\losfit_producao_$timestamp.zip"
$tempDir = "c:\xampp\htdocs\ecommerce\temp_producao"

Write-Host "=== Criando pacote de producao para losfit.com.br ===" -ForegroundColor Cyan

# Remove diretório temporário se existir
if (Test-Path $tempDir) {
    Write-Host "Removendo diretorio temporario antigo..." -ForegroundColor Yellow
    Remove-Item -Path $tempDir -Recurse -Force -ErrorAction SilentlyContinue
}

# Remove arquivo zip antigo se existir
if (Test-Path $outputZip) {
    Write-Host "Removendo arquivo .zip antigo..." -ForegroundColor Yellow
    Remove-Item -Path $outputZip -Force -ErrorAction SilentlyContinue
}

# Cria diretório temporário
Write-Host "Criando diretorio temporario..." -ForegroundColor Green
New-Item -ItemType Directory -Path $tempDir -Force | Out-Null

# Copia TUDO primeiro
Write-Host "Copiando todos os arquivos..." -ForegroundColor Green
Copy-Item -Path "$projectPath\*" -Destination $tempDir -Recurse -Force -ErrorAction SilentlyContinue

# Agora remove os diretórios não necessários
Write-Host "Removendo diretorios desnecessarios..." -ForegroundColor Yellow
$removeDirs = @(
    ".git",
    ".github",
    ".idea",
    ".vscode",
    ".fleet",
    ".nova",
    ".agent",
    "node_modules",
    "vendor",
    "tests",
    ".phpunit.cache"
)

foreach ($dir in $removeDirs) {
    $fullPath = Join-Path $tempDir $dir
    if (Test-Path $fullPath) {
        Write-Host "  Removendo: $dir" -ForegroundColor DarkGray
        Remove-Item -Path $fullPath -Recurse -Force -ErrorAction SilentlyContinue
    }
}

# Remove arquivos específicos
Write-Host "Removendo arquivos de desenvolvimento..." -ForegroundColor Yellow
$removePatterns = @(
    "*.log",
    ".env",
    ".env.backup",
    ".env.mysql",
    ".phpactor.json",
    ".phpunit.result.cache",
    "*.tar.gz",
    "debug_*.php",
    "debug_*.txt",
    "debug_*.html",
    "test_*.php",
    "check_*.php",
    "sync_*.php",
    "fix_*.php",
    "fetch_*.php",
    "update_*.php",
    "*.sql",
    "deploy.ps1",
    "deploy_manual.ps1",
    "configure.ps1",
    "create_production_zip.ps1",
    "git_deploy.sh",
    "server_deploy_commands.sh",
    "package-lock.json",
    "composer.lock"
)

foreach ($pattern in $removePatterns) {
    Get-ChildItem -Path $tempDir -Filter $pattern -Recurse -File -ErrorAction SilentlyContinue | ForEach-Object {
        Write-Host "  Removendo: $($_.Name)" -ForegroundColor DarkGray
        Remove-Item $_.FullName -Force -ErrorAction SilentlyContinue
    }
}

# Remove arquivos específicos da raiz
$rootFiles = @("id_rsa_hostinger", "id_rsa_hostinger.pub", "hostinger.env", "hostinger.htaccess")
foreach ($file in $rootFiles) {
    $fullPath = Join-Path $tempDir $file
    if (Test-Path $fullPath) {
        Write-Host "  Removendo: $file" -ForegroundColor DarkGray
        Remove-Item -Path $fullPath -Force -ErrorAction SilentlyContinue
    }
}

# Remove arquivos .md
Get-ChildItem -Path $tempDir -Filter "*.md" -File -ErrorAction SilentlyContinue | ForEach-Object {
    Write-Host "  Removendo: $($_.Name)" -ForegroundColor DarkGray
    Remove-Item $_.FullName -Force -ErrorAction SilentlyContinue
}

# Limpa diretórios de cache e logs
Write-Host "Limpando cache e logs..." -ForegroundColor Yellow
$cleanDirs = @(
    "storage\framework\cache\data",
    "storage\framework\sessions",
    "storage\framework\views",
    "storage\logs"
)

foreach ($dir in $cleanDirs) {
    $fullPath = Join-Path $tempDir $dir
    if (Test-Path $fullPath) {
        Get-ChildItem -Path $fullPath -Exclude ".gitkeep" -ErrorAction SilentlyContinue | Remove-Item -Recurse -Force -ErrorAction SilentlyContinue
        # Garante que .gitkeep existe
        $gitkeep = Join-Path $fullPath ".gitkeep"
        if (-not (Test-Path $gitkeep)) {
            New-Item -ItemType File -Path $gitkeep -Force | Out-Null
        }
    }
}

# Garante diretórios necessários
Write-Host "Garantindo estrutura de diretorios do Laravel..." -ForegroundColor Green
$requiredDirs = @(
    "bootstrap\cache",
    "storage\app\public",
    "storage\framework\cache\data",
    "storage\framework\sessions",
    "storage\framework\testing",
    "storage\framework\views",
    "storage\logs"
)

foreach ($dir in $requiredDirs) {
    $fullPath = Join-Path $tempDir $dir
    if (-not (Test-Path $fullPath)) {
        New-Item -ItemType Directory -Path $fullPath -Force | Out-Null
    }
    $gitkeep = Join-Path $fullPath ".gitkeep"
    if (-not (Test-Path $gitkeep)) {
        New-Item -ItemType File -Path $gitkeep -Force | Out-Null
    }
}

# Cria .env.example
$envExample = Join-Path $tempDir ".env.example"
$envProdExample = Join-Path $tempDir ".env.production.example"
if ((Test-Path $envProdExample) -and (-not (Test-Path $envExample))) {
    Write-Host "Copiando .env.production.example para .env.example..." -ForegroundColor Green
    Copy-Item -Path $envProdExample -Destination $envExample -Force
}

# Adiciona README de instalação
Write-Host "Criando README_INSTALACAO.txt..." -ForegroundColor Green
$readmeContent = @"
=== INSTRUCOES DE INSTALACAO - LOSFIT.COM.BR ===

1. UPLOAD DOS ARQUIVOS
   - Extraia este arquivo .zip no diretorio public_html do seu servidor

2. CONFIGURACAO DO AMBIENTE
   - Renomeie .env.example para .env
   - Edite o arquivo .env com as configuracoes do servidor:
     * DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
     * APP_URL=https://losfit.com.br
     * APP_ENV=production
     * APP_DEBUG=false

3. INSTALAR DEPENDENCIAS (via SSH)
   - composer install --optimize-autoloader --no-dev
   - npm install
   - npm run build

4. PERMISSOES (via SSH)
   - chmod -R 775 storage
   - chmod -R 775 bootstrap/cache

5. OTIMIZACAO (via SSH)
   - php artisan config:cache
   - php artisan route:cache
   - php artisan view:cache
   - php artisan storage:link

6. BANCO DE DADOS
   - O banco de dados ja foi instalado conforme indicado
   - Se necessario: php artisan migrate --force

7. VERIFICACAO
   - Acesse https://losfit.com.br para verificar se o site esta funcionando

IMPORTANTE:
- Certifique-se de que o DocumentRoot aponta para a pasta /public
- Verifique se o mod_rewrite esta habilitado
- Configure SSL/HTTPS no servidor
"@

$readmePath = Join-Path $tempDir "README_INSTALACAO.txt"
Set-Content -Path $readmePath -Value $readmeContent -Encoding UTF8

# Cria o arquivo .zip
Write-Host "`nCriando arquivo .zip (isso pode demorar alguns minutos)..." -ForegroundColor Cyan
# Lista todos os itens dentro do diretório temporário e compacta mantendo a estrutura
$items = Get-ChildItem -Path $tempDir -Recurse
Compress-Archive -Path (Get-ChildItem -Path $tempDir).FullName -DestinationPath $outputZip -Force

# Remove diretório temporário
Write-Host "Limpando arquivos temporarios..." -ForegroundColor Yellow
Remove-Item -Path $tempDir -Recurse -Force -ErrorAction SilentlyContinue

# Exibe informações do arquivo criado
if (Test-Path $outputZip) {
    $zipInfo = Get-Item $outputZip
    Write-Host "`n=== PACOTE CRIADO COM SUCESSO ===" -ForegroundColor Green
    Write-Host "Arquivo: $outputZip" -ForegroundColor Cyan
    Write-Host "Tamanho: $([math]::Round($zipInfo.Length / 1MB, 2)) MB" -ForegroundColor Cyan
    Write-Host "`nO pacote esta pronto para upload para losfit.com.br" -ForegroundColor Green
}
else {
    Write-Host "`n=== ERRO AO CRIAR PACOTE ===" -ForegroundColor Red
    Write-Host "O arquivo .zip nao foi criado. Verifique os erros acima." -ForegroundColor Red
}
