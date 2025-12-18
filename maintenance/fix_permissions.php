<?php
// fix_permissions.php
// Script de emergência para corrigir permissões na Hostinger
// Use isso se o acesso SSH falhar.

header('Content-Type: text/plain');

echo "Iniciando correção de permissões...\n";

function recursiveChmod($path, $filePerm=0644, $dirPerm=0755) {
    if (!file_exists($path)) {
        return;
    }
    if (is_dir($path)) {
        $foldersAndFiles = scandir($path);
        foreach ($foldersAndFiles as $folderOrFile) {
            if ($folderOrFile != '.' && $folderOrFile != '..') {
                recursiveChmod($path . '/' . $folderOrFile, $filePerm, $dirPerm);
            }
        }
        echo "DIR: " . $path . "\n";
        chmod($path, $dirPerm);
    } else {
        echo "FILE: " . $path . "\n";
        chmod($path, $filePerm);
    }
}

// 1. Corrigir tudo para 755 (Dirs) e 644 (Files)
echo "--- Ajustando Base ---\n";
recursiveChmod(__DIR__, 0644, 0755);

// 2. Storage e Cache precisam de 777 (ou 775 dependendo do grupo)
echo "--- Ajustando Storage (777) ---\n";
if (file_exists(__DIR__ . '/storage')) {
    recursiveChmod(__DIR__ . '/storage', 0666, 0777); // 666 para arquivos escritos serem editáveis
    // Forçar diretórios storage explicitamente
    $iter = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(__DIR__ . '/storage', RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST,
        RecursiveIteratorIterator::CATCH_GET_CHILD
    );
    foreach ($iter as $path => $dir) {
        if ($dir->isDir()) {
            chmod($path, 0777);
        }
    }
}

if (file_exists(__DIR__ . '/bootstrap/cache')) {
    chmod(__DIR__ . '/bootstrap/cache', 0777);
}

echo "\nCONCLUÍDO! Tente acessar o site agora.";
?>
