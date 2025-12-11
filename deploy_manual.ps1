$ErrorActionPreference = "Stop"

# --- CONFIGURAÇÃO ---
# Preencha estas variáveis com os dados do seu Hostinger
# Você pode encontrar esses dados no painel do Hostinger em "Acesso SSH"
$HOSTINGER_USER = "u488238372"      # Usuário extraído do DB_NAME
$HOSTINGER_IP = "185.245.180.69"      # IP SSH correto fornecido pelo usuário
$HOSTINGER_PORT = "65002"           # Porta padrão do Hostinger é 65002
$REMOTE_DIR = "public_html" # Tentativa na raiz, conforme screenshot e erro 404
$SSH_KEY_PATH = ""                  # Opcional: Caminho para sua chave privada (ex: "C:\Users\User\.ssh\id_rsa"). Deixe vazio para usar senha.

# Verifica se o usuário configurou o script
if ($HOSTINGER_USER -eq "u123456789") {
    Write-Host "ERRO: Você precisa editar o arquivo 'deploy_manual.ps1' e configurar as variáveis no topo (USER, IP, REMOTE_DIR) antes de executar." -ForegroundColor Red
    Exit
}

# Constrói os comandos base
if ($SSH_KEY_PATH) {
    $SSH_OPT = "-i `"$SSH_KEY_PATH`" -p $HOSTINGER_PORT"
    $SCP_OPT = "-i `"$SSH_KEY_PATH`" -P $HOSTINGER_PORT"
}
else {
    $SSH_OPT = "-p $HOSTINGER_PORT"
    $SCP_OPT = "-P $HOSTINGER_PORT"
}

Write-Host "=== 1. Preparando Build para Produção ===" -ForegroundColor Cyan
# Composer install will be done remotely on Hostinger
# cmd /c composer install --no-dev --optimize-autoloader --no-interaction

Write-Host "Compilando assets (NPM)..."
cmd /c npm install
cmd /c npm run build

Write-Host "=== 2. Empacotando Arquivos ===" -ForegroundColor Cyan
$PackageName = "deploy_release.tar.gz"
if (Test-Path $PackageName) { Remove-Item $PackageName -Force -ErrorAction SilentlyContinue }

Write-Host "Criando $PackageName..."
# Exclui arquivos desnecessários para produção
tar -czf $PackageName --exclude=.git --exclude=.github --exclude=node_modules --exclude=vendor --exclude=tests --exclude=.env --exclude=storage/logs --exclude=storage/framework/sessions --exclude=deploy_manual.ps1 .

if (-not (Test-Path $PackageName)) {
    Write-Host "ERRO CRÍTICO: Falha ao criar $PackageName" -ForegroundColor Red
    Exit
}

Write-Host "=== 3. Enviando para o Servidor ===" -ForegroundColor Cyan
$Destination = "${HOSTINGER_USER}@${HOSTINGER_IP}:${REMOTE_DIR}/$PackageName"
Write-Host "Enviando $PackageName para $Destination..."
Write-Host "Dica: Se pedir senha, digite a senha SSH/FTP do Hostinger." -ForegroundColor Yellow

# Executa SCP do pacote
Invoke-Expression "scp $SCP_OPT $PackageName $Destination"

# Executa SCP do arquivo .env
Write-Host "Enviando arquivo .env (hostinger.env) atualizado..."
Invoke-Expression "scp $SCP_OPT hostinger.env ${HOSTINGER_USER}@${HOSTINGER_IP}:${REMOTE_DIR}/.env"

# Executa SCP do arquivo .htaccess (root)
Write-Host "Enviando arquivo .htaccess (hostinger.htaccess) atualizado..."
Invoke-Expression "scp $SCP_OPT hostinger.htaccess ${HOSTINGER_USER}@${HOSTINGER_IP}:${REMOTE_DIR}/.htaccess"

# Executa SCP do arquivo version.php (para teste)
Write-Host "Enviando arquivo de verificação (version.php)..."
Invoke-Expression "scp $SCP_OPT version.php ${HOSTINGER_USER}@${HOSTINGER_IP}:${REMOTE_DIR}/public/version.php"

Write-Host "=== 4. Executando Comandos no Servidor ===" -ForegroundColor Cyan
# Comandos para rodar lá no servidor: Limpar (preservando .env/storage), extrair, migrar
$RemoteCommands = "cd $REMOTE_DIR && echo '1. Limpando public_html...' && find . -maxdepth 1 ! -name '.env' ! -name '.htaccess' ! -name 'storage' ! -name '$PackageName' ! -name '.' ! -name '..' -exec rm -rf {} + && echo '2. Extraindo arquivos...' && tar -xzf $PackageName && rm $PackageName && echo '3. Instalando dependências (PHP 8.4)...' && /opt/alt/php84/usr/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader --no-scripts && echo '4. Configurando Laravel...' && /opt/alt/php84/usr/bin/php artisan package:discover --ansi && /opt/alt/php84/usr/bin/php artisan config:clear && echo '5. Corrigindo Storage...' && rm -rf public/storage && ln -sfn ../storage/app/public public/storage && echo '6. Database: Reset & Seed...' && /opt/alt/php84/usr/bin/php artisan migrate:fresh --seed --force && /opt/alt/php84/usr/bin/php artisan optimize:clear && echo '--- Deploy Completo (Clean + Seed) Finalizado ---'"

Write-Host "Conectando via SSH para finalizar o deploy..."
Invoke-Expression "ssh $SSH_OPT ${HOSTINGER_USER}@${HOSTINGER_IP} `"$RemoteCommands`""

Write-Host "=== Concluído ===" -ForegroundColor Green
Write-Host "Nota: Seu ambiente local está agora com dependências de produção (--no-dev). Rode 'composer install' para voltar a desenvolver." -ForegroundColor Yellow
