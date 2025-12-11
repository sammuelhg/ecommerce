$ErrorActionPreference = "Stop"

# --- CONFIGURAÇÃO ---
$HOSTINGER_USER = "u488238372"
$HOSTINGER_IP = "91.108.127.41"
$REMOTE_DIR = "public_html" 

Write-Host "=== Diagnóstico do Servidor ===" -ForegroundColor Cyan
Write-Host "Listando arquivos em: $REMOTE_DIR"

# Comando para listar arquivos detalhadamente
$Cmd = "ls -la $REMOTE_DIR"
$Cmd2 = "ls -la $REMOTE_DIR/public"

Write-Host "Tentando conectar..."
ssh ${HOSTINGER_USER}@${HOSTINGER_IP} "$Cmd && echo '--- DENTRO DE PUBLIC ---' && $Cmd2"

Write-Host "=== Fim do Diagnóstico ==="
