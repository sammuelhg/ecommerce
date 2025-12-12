<?php
// public/debug.php
// Script para diagnosticar Erro 500

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>🕵️‍♂️ LosFit Debugger</h1>";

echo "<h2>1. Checando Arquivos Críticos</h2>";
$files = [
    '../.env',
    '../vendor/autoload.php',
    '../bootstrap/app.php',
    '../artisan'
];

foreach ($files as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ Encontrado: $file<br>";
    } else {
        echo "❌ <b>SUMIU:</b> $file<br>";
    }
}

echo "<h2>2. Checando Permissões de Escrita</h2>";
$dirs = [
    '../storage',
    '../storage/logs',
    '../storage/framework',
    '../storage/framework/views',
    '../bootstrap/cache'
];

foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_writable($path)) {
        echo "✅ Editável: $dir (" . substr(sprintf('%o', fileperms($path)), -4) . ")<br>";
    } else {
        echo "❌ <b>BLOQUEADO:</b> $dir (" . (file_exists($path) ? substr(sprintf('%o', fileperms($path)), -4) : 'Não existe') . ")<br>";
    }
}

echo "<h2>3. Tentando Carregar o Laravel</h2>";
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Tentar resolver o Kernel HTTP apenas para ver se crasha
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    echo "✅ Laravel carregou o Kernel com sucesso! (O erro não é no boot básico)<br>";
    
    // Check Database connection from Laravel
    echo "<h2>4. Teste de Banco via Laravel</h2>";
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        echo "✅ Laravel conectou no banco: " . \Illuminate\Support\Facades\DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        echo "❌ Erro de Conexão Laravel: " . $e->getMessage();
    }

} catch (\Throwable $e) {
    echo "❌ <b>CRASH FATAL AO CARREGAR LARAVEL:</b><br>";
    echo "Mensagem: " . $e->getMessage() . "<br>";
    echo "Arquivo: " . $e->getFile() . " na linha " . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
