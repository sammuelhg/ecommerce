<?php
// public/db_test.php
// Script Seguro de Teste de Conexão MySQL

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔍 Teste de Conexão MySQL</h1>";
echo "<pre style='background: #e8eaf6; padding: 15px; border-radius: 5px; border: 1px solid #3f51b5;'>";

// Credenciais (Hardcoded para teste isolado)
$host = '127.0.0.1';
$db   = 'u488238372_losfit';
$user = 'u488238372_losfit';
$pass = '!Sa002125';
$charset = 'utf8mb4';

echo "Tentando conectar em:\n";
echo "Host: $host\n";
echo "Database: $db\n";
echo "User: $user\n";
echo "---------------------------------\n";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "✅ CONEXÃO BEM SUCEDIDA!\n\n";

    // Criar Tabela de Teste
    echo "Criando tabela de teste '_test_check'...\n";
    $pdo->exec("CREATE TABLE IF NOT EXISTS _test_check (
        id INT AUTO_INCREMENT PRIMARY KEY,
        message VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✅ Tabela '_test_check' criada/verificada.\n";

    // Inserir Dados
    echo "Inserindo registo de teste...\n";
    $stm = $pdo->prepare("INSERT INTO _test_check (message) VALUES (?)");
    $stm->execute(['Teste de conexão: ' . date('Y-m-d H:i:s')]);
    echo "✅ Dado inserido.\n";

    // Ler Dados
    echo "Lendo dados...\n";
    $stmt = $pdo->query("SELECT * FROM _test_check ORDER BY id DESC LIMIT 3");
    while ($row = $stmt->fetch()) {
        echo "ID: " . $row['id'] . " | Msg: " . $row['message'] . "\n";
    }

    echo "\n---------------------------------\n";
    echo "CONCLUSÃO: Estamos conectados no banco CORRETO ($db).\n";
    echo "Pode rodar o instalador sem medo.";

} catch (\PDOException $e) {
    echo "❌ FALHA NA CONEXÃO:\n";
    echo $e->getMessage() . "\n";
    echo "Código: " . $e->getCode();
}

echo "</pre>";
?>
