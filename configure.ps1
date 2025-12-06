$serverUser = "u488238372"
$serverIp = "185.245.180.69"
$serverPort = "65002"
$remotePath = "~/domains/losfit.com.br/public_html"
$phpCmd = "/opt/alt/php82/usr/bin/php"

Write-Host "Configuring server environment..." -ForegroundColor Cyan

$commands = @(
    "cd $remotePath",
    
    # Update .env
    "sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env",
    "sed -i 's/DB_HOST=127.0.0.1/DB_HOST=127.0.0.1/' .env",
    "sed -i 's/DB_PORT=3306/DB_PORT=3306/' .env",
    "sed -i 's/DB_DATABASE=.*/DB_DATABASE=u488238372_losfit/' .env",
    "sed -i 's/DB_USERNAME=.*/DB_USERNAME=u488238372_losfit/' .env",
    "sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=\!Sa002125/' .env",
    
    # Create .htaccess for redirection
    "echo '<IfModule mod_rewrite.c>' > .htaccess",
    "echo 'RewriteEngine On' >> .htaccess",
    "echo 'RewriteRule ^(.*)$ public/\$1 [L]' >> .htaccess",
    "echo '</IfModule>' >> .htaccess",
    
    # Run migrations
    "echo 'Running migrations...'",
    "$phpCmd artisan migrate --force",
    
    # Clear cache
    "echo 'Clearing cache...'",
    "$phpCmd artisan config:clear",
    "$phpCmd artisan route:clear",
    "$phpCmd artisan view:clear",
    
    "echo 'Configuration complete!'"
)

$remoteCommand = $commands -join " && "

ssh -p $serverPort "${serverUser}@${serverIp}" $remoteCommand
