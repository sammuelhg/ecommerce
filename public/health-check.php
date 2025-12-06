<?php
/**
 * LosFit Health Check - Script de Verificação Pós-Migração
 * ATENÇÃO: Remover após verificação por segurança!
 * 
 * Acesse: https://losfit.com.br/health-check.php
 */

// Token simples de segurança (opcional - descomente para proteger)
// $token = $_GET['token'] ?? '';
// if ($token !== 'losfit2024') { die('Acesso negado'); }

header('Content-Type: text/html; charset=utf-8');

echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>LosFit Health Check</title>';
echo '<style>
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; max-width: 900px; margin: 40px auto; padding: 20px; background: #1a1a2e; color: #eee; }
    h1 { color: #ffc107; border-bottom: 2px solid #ffc107; padding-bottom: 10px; }
    h2 { color: #00d4ff; margin-top: 30px; }
    .check { padding: 12px 16px; margin: 8px 0; border-radius: 8px; display: flex; align-items: center; gap: 12px; }
    .ok { background: rgba(40, 167, 69, 0.2); border-left: 4px solid #28a745; }
    .error { background: rgba(220, 53, 69, 0.2); border-left: 4px solid #dc3545; }
    .warning { background: rgba(255, 193, 7, 0.2); border-left: 4px solid #ffc107; }
    .icon { font-size: 20px; }
    .label { flex: 1; }
    .value { font-family: monospace; font-size: 13px; opacity: 0.8; }
    pre { background: #0d0d1a; padding: 15px; border-radius: 8px; overflow-x: auto; font-size: 13px; }
    .danger-notice { background: #dc3545; color: white; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center; }
</style></head><body>';

echo '<h1>🏋️ LosFit - Health Check</h1>';
echo '<p>Verificação realizada em: <strong>' . date('d/m/Y H:i:s') . '</strong></p>';

// Tentar carregar Laravel
$laravelLoaded = false;
$basePath = dirname(__DIR__);

try {
    require $basePath . '/vendor/autoload.php';
    $app = require_once $basePath . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $kernel->bootstrap();
    $laravelLoaded = true;
} catch (Exception $e) {
    echo '<div class="check error"><span class="icon">❌</span><span class="label">Laravel não carregou: ' . $e->getMessage() . '</span></div>';
}

function checkResult($condition, $label, $successValue = 'OK', $errorValue = 'ERRO') {
    $class = $condition ? 'ok' : 'error';
    $icon = $condition ? '✅' : '❌';
    $value = $condition ? $successValue : $errorValue;
    echo "<div class='check $class'><span class='icon'>$icon</span><span class='label'>$label</span><span class='value'>$value</span></div>";
    return $condition;
}

function warnResult($label, $value) {
    echo "<div class='check warning'><span class='icon'>⚠️</span><span class='label'>$label</span><span class='value'>$value</span></div>";
}

// ===== CONFIGURAÇÕES =====
echo '<h2>🔐 Segurança & Configuração</h2>';

if ($laravelLoaded) {
    checkResult(env('APP_ENV') === 'production', 'APP_ENV', env('APP_ENV'), env('APP_ENV') . ' (deveria ser production)');
    checkResult(env('APP_DEBUG') === false, 'APP_DEBUG', 'false', 'true ⚠️ DESATIVE!');
    checkResult(!empty(env('APP_KEY')), 'APP_KEY definida', 'Configurada', 'NÃO DEFINIDA!');
    checkResult(str_contains(env('APP_URL', ''), 'losfit.com.br'), 'APP_URL', env('APP_URL'), env('APP_URL') . ' (deveria apontar para losfit.com.br)');
    
    // HTTPS
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    checkResult($isHttps, 'HTTPS/SSL', 'Ativo', 'NÃO ATIVO');
}

// ===== BANCO DE DADOS =====
echo '<h2>🗄️ Banco de Dados</h2>';

if ($laravelLoaded) {
    try {
        $dbConnection = env('DB_CONNECTION', 'mysql');
        $dbName = env('DB_DATABASE');
        
        // Testar conexão
        DB::connection()->getPdo();
        checkResult(true, 'Conexão com MySQL', $dbName);
        
        // Verificar tabelas
        $tables = DB::select('SHOW TABLES');
        $tableCount = count($tables);
        checkResult($tableCount > 0, 'Tabelas no banco', $tableCount . ' tabelas');
        
        // Verificar migrations
        $migrations = DB::table('migrations')->count();
        checkResult($migrations > 0, 'Migrations executadas', $migrations . ' migrations');
        
        // Contar registros importantes
        echo '<h3>📊 Contagem de Registros</h3>';
        
        $counts = [
            'users' => 'Usuários',
            'products' => 'Produtos',
            'categories' => 'Categorias',
            'product_images' => 'Imagens de Produtos',
            'orders' => 'Pedidos',
        ];
        
        foreach ($counts as $table => $label) {
            try {
                $count = DB::table($table)->count();
                echo "<div class='check ok'><span class='icon'>📦</span><span class='label'>$label</span><span class='value'>$count registros</span></div>";
            } catch (Exception $e) {
                echo "<div class='check warning'><span class='icon'>⚠️</span><span class='label'>$label</span><span class='value'>Tabela não existe</span></div>";
            }
        }
        
    } catch (Exception $e) {
        checkResult(false, 'Conexão com MySQL', '', $e->getMessage());
    }
}

// ===== STORAGE =====
echo '<h2>📁 Arquivos & Storage</h2>';

// Verificar symlink
$storageLink = $basePath . '/public/storage';
$symlinkExists = is_link($storageLink) || is_dir($storageLink);
checkResult($symlinkExists, 'Symlink storage/public', 'Configurado', 'NÃO EXISTE - execute: php artisan storage:link');

// Verificar pastas com permissão de escrita
$storagePath = $basePath . '/storage';
$cachePath = $basePath . '/bootstrap/cache';

checkResult(is_writable($storagePath), 'Pasta storage', 'Escrita OK', 'SEM PERMISSÃO');
checkResult(is_writable($cachePath), 'Pasta bootstrap/cache', 'Escrita OK', 'SEM PERMISSÃO');

// Verificar uploads
$uploadsPath = $basePath . '/storage/app/public/products';
if (is_dir($uploadsPath)) {
    $uploadedImages = count(glob($uploadsPath . '/*'));
    echo "<div class='check ok'><span class='icon'>🖼️</span><span class='label'>Imagens em /products</span><span class='value'>$uploadedImages arquivos</span></div>";
} else {
    warnResult('Pasta de produtos', 'Não existe ainda (normal se não há uploads)');
}

// ===== PHP =====
echo '<h2>⚙️ Ambiente PHP</h2>';

checkResult(PHP_VERSION_ID >= 80200, 'Versão PHP', 'PHP ' . PHP_VERSION, 'PHP ' . PHP_VERSION . ' (precisa 8.2+)');

$uploadMax = ini_get('upload_max_filesize');
$postMax = ini_get('post_max_size');
$memoryLimit = ini_get('memory_limit');

echo "<div class='check ok'><span class='icon'>📤</span><span class='label'>upload_max_filesize</span><span class='value'>$uploadMax</span></div>";
echo "<div class='check ok'><span class='icon'>📤</span><span class='label'>post_max_size</span><span class='value'>$postMax</span></div>";
echo "<div class='check ok'><span class='icon'>💾</span><span class='label'>memory_limit</span><span class='value'>$memoryLimit</span></div>";

// Extensões necessárias
$requiredExtensions = ['pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'gd'];
echo '<h3>Extensões PHP</h3>';
foreach ($requiredExtensions as $ext) {
    checkResult(extension_loaded($ext), "Extensão: $ext");
}

// ===== CACHE =====
echo '<h2>🚀 Cache & Performance</h2>';

if ($laravelLoaded) {
    $configCached = file_exists($basePath . '/bootstrap/cache/config.php');
    $routesCached = file_exists($basePath . '/bootstrap/cache/routes-v7.php');
    
    checkResult($configCached, 'Config Cache', 'Ativo', 'Não ativo - execute: php artisan config:cache');
    checkResult($routesCached, 'Route Cache', 'Ativo', 'Não ativo - execute: php artisan route:cache');
}

// ===== SEGURANÇA EXTRA =====
echo '<h2>🛡️ Verificações de Segurança</h2>';

// Verificar se .env está acessível
$envUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/.env';
$ch = curl_init($envUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

checkResult($httpCode === 403 || $httpCode === 404, 'Arquivo .env protegido', 'Bloqueado (HTTP ' . $httpCode . ')', 'ACESSÍVEL! PERIGO! (HTTP ' . $httpCode . ')');

// Verificar listagem de diretório
$storageUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/storage/';
$ch = curl_init($storageUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$content = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$indexShowing = strpos($content, 'Index of') !== false;
checkResult(!$indexShowing, 'Listagem de diretório bloqueada', 'Bloqueada', 'ATIVA - configure .htaccess!');

// ===== AVISO FINAL =====
echo '<div class="danger-notice">';
echo '<strong>⚠️ IMPORTANTE:</strong> Remova este arquivo após a verificação!<br>';
echo 'Comando: <code>rm public/health-check.php</code>';
echo '</div>';

echo '<h2>📋 Próximos Passos</h2>';
echo '<pre>';
echo "# Se precisar criar o symlink de storage:\n";
echo "/opt/alt/php82/usr/bin/php artisan storage:link\n\n";
echo "# Se precisar ativar caches:\n";
echo "/opt/alt/php82/usr/bin/php artisan config:cache\n";
echo "/opt/alt/php82/usr/bin/php artisan route:cache\n";
echo "/opt/alt/php82/usr/bin/php artisan view:cache\n\n";
echo "# Para remover este arquivo:\n";
echo "rm public/health-check.php\n";
echo '</pre>';

echo '</body></html>';
