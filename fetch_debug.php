<?php
$url = 'http://localhost:8000/loja/produto/whey-protein-concentrado-em-cafeina-rosa-tamanho-m';
$context = stream_context_create([
    'http' => [
        'ignore_errors' => true
    ]
]);
$content = file_get_contents($url, false, $context);
echo $content;
