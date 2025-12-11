$ErrorActionPreference = "Stop"

# --- CONFIGURAÇÃO ---
$HOSTINGER_USER = "u488238372"
$HOSTINGER_IP = "185.245.180.69"
$HOSTINGER_PORT = "65002"
$REMOTE_DIR = "public_html"
$SSH_OPT = "-p $HOSTINGER_PORT"
$SCP_OPT = "-P $HOSTINGER_PORT"

Write-Host "=== REPARO DE DEPLOY ===" -ForegroundColor Cyan
Write-Host "1. Restaurando .htaccess (Correção do Erro 403)..."
Invoke-Expression "scp $SCP_OPT hostinger.htaccess ${HOSTINGER_USER}@${HOSTINGER_IP}:${REMOTE_DIR}/.htaccess"

Write-Host "2. Finalizando Configuração (Storage + Banco)..."
# Comandos que faltaram rodar porque o script parou
$RemoteCommands = "cd $REMOTE_DIR && echo '> Listando arquivos (Debug)...' && ls -R | head -n 20 && echo '> Criando Symlink Storage...' && rm -rf public/storage && ln -sfn ../storage/app/public public/storage && echo '> Tentando Rodar Migrations/Seed...' && /opt/alt/php84/usr/bin/php artisan migrate:fresh --seed --force && echo '> Limpando Cache...' && /opt/alt/php84/usr/bin/php artisan optimize:clear && echo '=== REPARO CONCLUÍDO ==='"

Write-Host "Conectando para rodar comandos..."
Invoke-Expression "ssh $SSH_OPT ${HOSTINGER_USER}@${HOSTINGER_IP} `"$RemoteCommands`""
