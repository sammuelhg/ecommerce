# Script DEFINITIVO para criar pacote de producao para losfit.com.br
# Usa biblioteca .NET diretamente para garantir estrutura correta

Add-Type -AssemblyName System.IO.Compression.FileSystem

$projectPath = "c:\xampp\htdocs\ecommerce\ecommerce-hp"
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$outputZip = "c:\xampp\htdocs\ecommerce\losfit_producao_FINAL_$timestamp.zip"
$tempDir = "c:\xampp\htdocs\ecommerce\temp_producao_final"

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  CRIANDO PACOTE DE PRODUCAO - LOSFIT  " -ForegroundColor Cyan
Write-Host "========================================`n" -ForegroundColor Cyan

# Limpa ambiente
if (Test-Path $tempDir) {
    Write-Host "[1/6] Removendo diretorio temporario antigo..." -ForegroundColor Yellow
    Remove-Item -Path $tempDir -Recurse -Force -ErrorAction SilentlyContinue
}

if (Test-Path $outputZip) {
    Write-Host "[1/6] Removendo arquivo .zip antigo..." -ForegroundColor Yellow
    Remove-Item -Path $outputZip -Force -ErrorAction SilentlyContinue
}

# Cria diretorio temporario
Write-Host "[2/6] Criando diretorio temporario..." -ForegroundColor Green
New-Item -ItemType Directory -Path $tempDir -Force | Out-Null

# Copia TUDO primeiro
Write-Host "[3/6] Copiando arquivos do projeto..." -ForegroundColor Green
Copy-Item -Path "$projectPath\*" -Destination $tempDir -Recurse -Force -ErrorAction SilentlyContinue

# Remove diretorios desnecessarios
Write-Host "[4/6] Removendo arquivos desnecessarios..." -ForegroundColor Yellow

$removeDirs = @(
    ".git", ".github", ".idea", ".vscode", ".fleet", ".nova", ".agent",
    "node_modules", "vendor", "tests", ".phpunit.cache"
)

foreach ($dir in $removeDirs) {
    $fullPath = Join-Path $tempDir $dir
    if (Test-Path $fullPath) {
        Remove-Item -Path $fullPath -Recurse -Force -ErrorAction SilentlyContinue
        Write-Host "  - Removido: $dir" -ForegroundColor DarkGray
    }
}

# Remove arquivos especificos
$removePatterns = @(
    "*.log", ".env", ".env.backup", ".env.mysql", ".phpactor.json",
    ".phpunit.result.cache", "*.tar.gz", "debug_*.php", "debug_*.txt",
    "debug_*.html", "test_*.php", "check_*.php", "sync_*.php", "fix_*.php",
    "fetch_*.php", "update_*.php", "*.sql", "deploy.ps1", "deploy_manual.ps1",
    "configure.ps1", "create_production_*.ps1", "git_deploy.sh",
    "server_deploy_commands.sh", "package-lock.json", "composer.lock"
)

foreach ($pattern in $removePatterns) {
    Get-ChildItem -Path $tempDir -Filter $pattern -Recurse -File -ErrorAction SilentlyContinue | ForEach-Object {
        Remove-Item $_.FullName -Force -ErrorAction SilentlyContinue
    }
}

# Remove arquivos especificos da raiz
$rootFiles = @("id_rsa_hostinger", "id_rsa_hostinger.pub", "hostinger.env", "hostinger.htaccess")
foreach ($file in $rootFiles) {
    $fullPath = Join-Path $tempDir $file
    if (Test-Path $fullPath) {
        Remove-Item -Path $fullPath -Force -ErrorAction SilentlyContinue
    }
}

# Remove arquivos .md
Get-ChildItem -Path $tempDir -Filter "*.md" -File -ErrorAction SilentlyContinue | ForEach-Object {
    Remove-Item $_.FullName -Force -ErrorAction SilentlyContinue
}

# Limpa cache e logs
$cleanDirs = @(
    "storage\framework\cache\data", "storage\framework\sessions",
    "storage\framework\views", "storage\logs"
)

foreach ($dir in $cleanDirs) {
    $fullPath = Join-Path $tempDir $dir
    if (Test-Path $fullPath) {
        Get-ChildItem -Path $fullPath -Exclude ".gitkeep" -ErrorAction SilentlyContinue | 
        Remove-Item -Recurse -Force -ErrorAction SilentlyContinue
        $gitkeep = Join-Path $fullPath ".gitkeep"
        if (-not (Test-Path $gitkeep)) {
            New-Item -ItemType File -Path $gitkeep -Force | Out-Null
        }
    }
}

# Garante diretorios necessarios
$requiredDirs = @(
    "bootstrap\cache", "storage\app\public", "storage\framework\cache\data",
    "storage\framework\sessions", "storage\framework\testing",
    "storage\framework\views", "storage\logs"
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
    Copy-Item -Path $envProdExample -Destination $envExample -Force
}

# Cria README de instalacao
$readmeContent = @"
=== INSTRUCOES DE INSTALACAO - LOSFIT.COM.BR ===

1. UPLOAD DOS ARQUIVOS
   - Extraia este arquivo .zip no diretorio public_html do seu servidor
   - IMPORTANTE: Todos os arquivos devem manter a estrutura de pastas

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

# ====================================
# CRIA O ZIP USANDO BIBLIOTECA .NET
# ====================================
Write-Host "[5/6] Criando arquivo .zip com biblioteca .NET..." -ForegroundColor Cyan
Write-Host "      (Isso pode demorar alguns minutos)" -ForegroundColor Gray

try {
    # Remove zip se existir
    if (Test-Path $outputZip) {
        Remove-Item $outputZip -Force
    }
    
    # Cria o arquivo ZIP usando o metodo que PRESERVA a estrutura
    # CompressionLevel.Optimal = melhor compressao
    # includeBaseDirectory = $false para nao criar pasta extra dentro do zip
    [System.IO.Compression.ZipFile]::CreateFromDirectory(
        $tempDir, 
        $outputZip, 
        [System.IO.Compression.CompressionLevel]::Optimal, 
        $false
    )
    
    Write-Host "      ZIP criado com sucesso!" -ForegroundColor Green
    
}
catch {
    Write-Host "      ERRO ao criar ZIP: $_" -ForegroundColor Red
    exit 1
}

# Remove diretorio temporario
Write-Host "[6/6] Limpando arquivos temporarios..." -ForegroundColor Yellow
Remove-Item -Path $tempDir -Recurse -Force -ErrorAction SilentlyContinue

# Exibe informacoes do arquivo criado
if (Test-Path $outputZip) {
    $zipInfo = Get-Item $outputZip
    Write-Host "`n========================================" -ForegroundColor Green
    Write-Host "  PACOTE CRIADO COM SUCESSO!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "`nArquivo: " -NoNewline -ForegroundColor White
    Write-Host $outputZip -ForegroundColor Cyan
    Write-Host "Tamanho: " -NoNewline -ForegroundColor White
    Write-Host "$([math]::Round($zipInfo.Length / 1MB, 2)) MB" -ForegroundColor Cyan
    Write-Host "`nO pacote esta pronto para upload!" -ForegroundColor Green
    Write-Host "Para losfit.com.br" -ForegroundColor Yellow
    Write-Host "`n========================================`n" -ForegroundColor Green
}
else {
    Write-Host "`n========================================" -ForegroundColor Red
    Write-Host "  ERRO AO CRIAR PACOTE" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "O arquivo .zip nao foi criado." -ForegroundColor Red
    Write-Host "Verifique os erros acima.`n" -ForegroundColor Red
}
