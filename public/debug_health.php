<?php
/**
 * Script de diagnóstico de saúde do servidor para Laravel
 * Acesse em: https://losfit.com.br/debug_health.php
 * RECOMENDAÇÃO: Delete este arquivo após o uso.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🚀 Diagnóstico Losfit - Hostinger</h1>";

// 1. Informações do PHP
echo "<h2>1. Ambiente PHP</h2>";
echo "Versão PHP: " . phpversion() . "<br>";
echo "Interface SAPI: " . php_sapi_name() . "<br>";
echo "Memória Limite: " . ini_get('memory_limit') . "<br>";

// 2. Verificação de Arquivos Críticos
echo "<h2>2. Arquivos do Sistema</h2>";
$basePath = dirname(__DIR__);
$files = [
    '.env' => $basePath . '/.env',
    '.htaccess' => __DIR__ . '/.htaccess',
    'vendor/autoload.php' => $basePath . '/vendor/autoload.php',
    'artisan' => $basePath . '/artisan'
];

foreach ($files as $name => $path) {
    echo "$name: " . (file_exists($path) ? "✅ Encontrado" : "❌ NÃO ENCONTRADO ($path)") . "<br>";
}

// 3. Permissões de Pastas
echo "<h2>3. Permissões de Pastas Site</h2>";
$directories = [
    'storage' => $basePath . '/storage',
    'storage/logs' => $basePath . '/storage/logs',
    'bootstrap/cache' => $basePath . '/bootstrap/cache'
];

foreach ($directories as $name => $path) {
    if (file_exists($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        echo "$name ($perms): " . (is_writable($path) ? "✅ Gravável" : "❌ SEM PERMISSÃO DE ESCRITA") . "<br>";
    } else {
        echo "$name: ❌ DIRETÓRIO NÃO EXISTE ($path)<br>";
    }
}

// 4. Teste de Conexão com Banco de Dados (Lendo do .env)
echo "<h2>4. Conexão com Banco de Dados</h2>";
if (file_exists($basePath . '/.env')) {
    $env_content = file_get_contents($basePath . '/.env');
    preg_match('/DB_HOST=(.*)/', $env_content, $host);
    preg_match('/DB_DATABASE=(.*)/', $env_content, $db);
    preg_match('/DB_USERNAME=(.*)/', $env_content, $user);
    preg_match('/DB_PASSWORD=(.*)/', $env_content, $pass);

    $db_host = trim($host[1] ?? '127.0.0.1');
    $db_name = trim($db[1] ?? '');
    $db_user = trim($user[1] ?? '');
    $db_pass = trim($pass[1] ?? '');

    echo "Tentando conectar ao banco: <b>$db_name</b> no host <b>$db_host</b>...<br>";

    try {
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_error) {
            echo "❌ FALHA NA CONEXÃO: " . $conn->connect_error;
        } else {
            echo "✅ CONEXÃO COM BANCO OK!<br>";
            
            $res = $conn->query("SHOW TABLES");
            $count = $res->num_rows;
            echo "📊 Total de Tabelas Encontradas: <strong>$count</strong><br>";
            
            // Verificação de Charset/Collation
            $res_charset = $conn->query("SELECT @@character_set_database, @@collation_database");
            $row_charset = $res_charset->fetch_assoc();
            echo "🔤 Charset do Banco: <strong>" . $row_charset['@@character_set_database'] . "</strong><br>";
            echo "🔡 Collation do Banco: <strong>" . $row_charset['@@collation_database'] . "</strong><br>";

            if ($count < 50) {
                echo "⚠️ Atenção: Menos de 50 tabelas encontradas. O banco pode estar incompleto.<br>";
            }
            
            $conn->close();
        }
    } catch (Exception $e) {
        echo "❌ ERRO: " . $e->getMessage();
    }
} else {
    echo "❌ Impossível testar banco: .env não encontrado.";
}

// 5. Extensões PHP Necessárias
echo "<h2>5. Extensões PHP Necessárias</h2>";
$required_extensions = ['bcmath', 'ctype', 'fileinfo', 'json', 'mbstring', 'openssl', 'pdo_mysql', 'tokenizer', 'xml', 'curl', 'gd'];
foreach ($required_extensions as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? "✅ OK" : "❌ FALTANDO") . "<br>";
}

// 6. Teste de Boot do Laravel e Páginas
echo "<h2>6. Teste de Boot do Laravel e Requisições</h2>";
try {
    echo "Tentando bootar o Laravel...<br>";
    if (file_exists($basePath . '/vendor/autoload.php') && file_exists($basePath . '/bootstrap/app.php')) {
        require_once $basePath . '/vendor/autoload.php';
        // Tenta capturar a saída do boot
        ob_start();
        $test_app = require_once $basePath . '/bootstrap/app.php';
        $test_kernel = $test_app->make(Illuminate\Contracts\Http\Kernel::class);
        echo "✅ Boot Framework OK!<br>";
        
        $app_key = env('APP_KEY');
        echo "APP_KEY: " . ($app_key ? "✅ Configurada" : "❌ NÃO ENCONTRADA") . "<br>";
        
        ob_end_clean();
    }
} catch (Throwable $e) {
    echo "❌ ERRO NO BOOT: " . $e->getMessage() . "<br>";
    echo "Arquivo: " . $e->getFile() . " (Linha " . $e->getLine() . ")<br>";
}

// Teste de requisições
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$routes_to_test = [
    'Página Inicial' => $baseUrl . '/',
    'Página de Login' => $baseUrl . '/login',
    'Dashboard Admin' => $baseUrl . '/admin'
];

foreach ($routes_to_test as $name => $url) {
    echo "Testando $name ($url)... ";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Não segue redirecionamento para testar o código real
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 400) {
        echo "✅ Status $httpCode<br>";
    } else {
        echo "❌ Status $httpCode (ERRO)<br>";
    }
}

// 7. Logs do Laravel
echo "<h2>7. Últimas linhas do log (Laravel)</h2>";
$logPath = $basePath . '/storage/logs/laravel.log';
if (file_exists($logPath)) {
    $logContent = array_slice(file($logPath), -40); // 40 linhas agora
    echo "<pre style='background: #f4f4f4; padding: 10px; font-size: 11px; overflow: auto; max-height: 400px;'>" . htmlspecialchars(implode("", $logContent)) . "</pre>";
} else {
    echo "Log do Laravel não encontrado.";
}

echo "<hr><p>Remova este arquivo do servidor após terminar o debug. v2.5</p>";

