#!/bin/bash

# Configuration for Hostinger (CloudLinux)
PHP_CMD="/opt/alt/php82/usr/bin/php"
COMPOSER_CMD="/usr/local/bin/composer"

echo "=========================================="
echo "   LosFit E-commerce Installer (Hostinger)"
echo "=========================================="

# 1. Check Environment
echo "[1/6] Checking Environment..."
if [ ! -f "$PHP_CMD" ]; then
    echo "Error: PHP 8.2 not found at $PHP_CMD"
    echo "Please update PHP_CMD in this script."
    exit 1
fi

# 2. Extract Files
if [ -f "release.tar.gz" ]; then
    echo "[2/6] Extracting release.tar.gz..."
    tar -xzf release.tar.gz
    # Remove archive after extraction? Optional. Keeping it acts as backup.
else
    echo "Notice: release.tar.gz not found. Assuming files are already uploaded."
fi

# 3. Setup .env
echo "[3/6] Configuring Environment (.env)..."
if [ ! -f ".env" ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
    echo "Generating Application Key..."
    $PHP_CMD artisan key:generate
    
    echo ""
    echo "IMPORTANT: Please edit .env file now with your Database Credentials."
    echo "Nano editor will open in 5 seconds..."
    sleep 5
    nano .env
else
    echo ".env already exists. Skipping configuration."
fi

# 4. Install Dependencies
echo "[4/6] Installing PHP Dependencies..."
$PHP_CMD $COMPOSER_CMD install --no-dev --optimize-autoloader

# 5. Setup Database & Storage
echo "[5/6] Finalizing Setup..."
echo "Running Migrations..."
$PHP_CMD artisan migrate --force

echo "Linking Storage..."
$PHP_CMD artisan storage:link

echo "Clearing Caches..."
$PHP_CMD artisan config:cache
$PHP_CMD artisan route:cache
$PHP_CMD artisan view:cache

# 6. Permissions
echo "[6/6] Setting Permissions..."
chmod -R 775 storage bootstrap/cache
find storage -type f -exec chmod 664 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;

echo "=========================================="
echo "   Installation Completed Successfully!   "
echo "=========================================="
