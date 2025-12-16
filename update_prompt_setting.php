<?php

use App\Models\StoreSetting;

require 'vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$newTemplate = "Atue como um Copywriter Sênior de E-commerce. Escreva uma descrição de produto completa e envolvente para a página de vendas em formato HTML.\n\nEstrutura Obrigatória (Use tags HTML):\n1. Título: Use <h1> para um título criativo com o nome do produto.\n2. Gancho Emocional: Use <p> para 2-3 frases focadas no problema/solução.\n3. Benefícios: Use <ul> e <li>. Use <strong> para destacar palavras-chave.\n4. Experiência: Use <p> para descrever material ({material}) e variante ({variant}).\n5. Regras Finais: NÃO inclua Chamada para Ação (CTA). NÃO use Markdown (** ou ##). Apenas HTML puro.\n\nDados do Produto:\nNome: {product_name}\nCategoria: {category}\nMaterial/Ingredientes: {material}\nDetalhes da Variante: {variant}\nTamanho: {size}";

StoreSetting::set('ai_description_prompt_template', $newTemplate);

echo "Prompt template updated successfully.\n";
