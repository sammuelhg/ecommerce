#!/bin/bash
# Script de deployment via Git no servidor Hostinger
# Execute: bash git_deploy.sh

set -e  # Para em caso de erro

echo "=== 1. Navegando para public_html ==="
cd ~/public_html

echo "=== 2. Verificando se já existe repositório Git ==="
if [ -d ".git" ]; then
    echo "Repositório Git encontrado. Fazendo pull das mudanças..."
    git pull origin main
else
    echo "Clonando repositório pela primeira vez..."
    # Limpa diretório se houver arquivos
    rm -rf * .[^.]* 2>/dev/null || true
    git clone https://github.com/sammuelhg/ecommerce.git .
fi

echo "=== 3. Copiando arquivo .env ==="
# Se você tiver um .env no servidor, mantenha. Senão, crie um baseado no .env.example
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "ATENÇÃO: Configure o arquivo .env com as credenciais corretas!"
fi

echo "=== 4. Instalando dependências do Composer ==="
composer install --no-dev --optimize-autoloader --no-interaction

echo "=== 5. Instalando e compilando assets (NPM) ==="
npm ci
npm run build

echo "=== 6. Executando migrations ==="
php artisan migrate --force

echo "=== 7. Limpando e criando caches ==="
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== 8. Ajustando permissões ==="
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs storage/framework

echo "=== ✅ Deployment concluído com sucesso! ==="
echo "Acesse: https://losfit.com.br"
