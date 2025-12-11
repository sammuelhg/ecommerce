#!/bin/bash
# Comandos para finalizar o deploy no servidor Hostinger
# Execute este script via SSH: bash server_deploy_commands.sh

echo "=== 1. Navegando para o diretório do projeto ==="
cd ~/public_html

echo "=== 2. Extraindo arquivos do pacote ==="
tar -xzf deploy_package.tar.gz

echo "=== 3. Instalando dependências do Composer ==="
composer install --no-dev --optimize-autoloader

echo "=== 4. Executando migrations ==="
php artisan migrate --force

echo "=== 5. Limpando cache ==="
php artisan optimize:clear

echo "=== 6. Criando caches otimizados ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== 7. Ajustando permissões ==="
chmod -R 755 storage bootstrap/cache

echo "=== Deployment concluído! ==="
echo "Verifique o site: https://losfit.com.br"
