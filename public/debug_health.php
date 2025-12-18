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
    $env = file_get_contents($basePath . '/.env');
    preg_match('/DB_HOST=(.*)/', $env, $host);
    preg_match('/DB_DATABASE=(.*)/', $env, $db);
    preg_match('/DB_USERNAME=(.*)/', $env, $user);
    preg_match('/DB_PASSWORD=(.*)/', $env, $pass);

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

// 5. Logs do Laravel
echo "<h2>5. Últimas linhas do log (Laravel)</h2>";
$logPath = $basePath . '/storage/logs/laravel.log';
if (file_exists($logPath)) {
    $logContent = array_slice(file($logPath), -20);
    echo "<pre style='background: #f4f4f4; padding: 10px;'>" . htmlspecialchars(implode("", $logContent)) . "</pre>";
} else {
    echo "Log do Laravel não encontrado.";
}

echo "<hr><p>Remova este arquivo do servidor após terminar o debug.</p>";
