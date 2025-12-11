# Método 1: Via .htaccess (SSH)

No SSH, execute:

```bash
cd ~/public_html

# Criar .htaccess para usar PHP 8.4
cat > .htaccess << 'EOF'
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php84 .php .php8 .phtml
</IfModule>
EOF

# Verificar se mudou:
php -v
```

# Método 2: Via Painel Hostinger (Recomendado)

1. Acesse o painel Hostinger
2. Vá em **Advanced** → **PHP Configuration**
3. Selecione **PHP 8.2** ou **PHP 8.4** para `sammuel.com.br`

# Após configurar PHP 8.2+

Continue o deployment no SSH:

```bash
cd ~/public_html
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 755 storage bootstrap/cache
```
