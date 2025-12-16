<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiContentService
{
    /**
     * Generate SEO Meta Description
     */
    public function generateSeoDescription(array $productData): ?string
    {
        $prompt = $this->buildSeoPrompt($productData);
        return $this->generateText($prompt);
    }

    /**
     * Generate Full Product Description
     */
    public function generateFullDescription(array $productData): ?string
    {
        $prompt = $this->buildFullDescriptionPrompt($productData);
        return $this->generateText($prompt);
    }

    /**
     * Build Optimized Image Prompt
     */
    public function buildImagePrompt(array $data): string
    {
        $template = \App\Models\StoreSetting::get('ai_image_prompt_template', 
            'Professional e-commerce product photography of {product_name}, {category} category product, {type} type, {model} model, {size} size, {variant}, {material} style. Studio lighting, clean white background, product centered, front view, label visible and readable, high resolution, professional packshot, 8k quality, photorealistic'
        );

        // Build visual variant description
        $variantParts = [];
        if (!empty($data['color'])) $variantParts[] = $data['color'] . " color";
        if (!empty($data['flavor'])) $variantParts[] = "visual cues of " . $data['flavor'] . " flavor";
        
        $variant = !empty($variantParts) ? implode(', ', $variantParts) : '';

        $replacements = [
            '{product_name}' => $data['name'] ?? 'product',
            '{category}' => $data['category'] ?? 'general',
            '{type}' => $data['type'] ?? '',
            '{model}' => $data['model'] ?? '',
            '{size}' => $data['size'] ?? '',
            '{variant}' => $variant,
            '{material}' => $data['material'] ?? '',
            // Keep specific tags just in case user wants to use them manually in custom templates
            '{color}' => $data['color'] ?? '',
            '{flavor}' => $data['flavor'] ?? '',
        ];

        $prompt = str_replace(array_keys($replacements), array_values($replacements), $template);
        
        // Clean up empty commas or double spaces that might result from empty tags
        $prompt = preg_replace('/,\s*,/', ',', $prompt);
        $prompt = preg_replace('/\s+/', ' ', $prompt);
        $prompt = str_replace(' ,', ',', $prompt);
        
        return trim($prompt);
    }

    public function buildSeoPrompt(array $data): string
    {
        $productName = $data['name'] ?? 'Produto';
        $category = $data['category'] ?? 'Geral';
        $model = $data['model'] ?? '';
        $type = $data['type'] ?? '';
        
        // Specific handling for variants as before
        $variantParts = [];
        if (!empty($data['color'])) $variantParts[] = "Cor: " . $data['color'];
        if (!empty($data['flavor'])) $variantParts[] = "Sabor: " . $data['flavor'];
        $variant = implode(', ', $variantParts);

        $template = \App\Models\StoreSetting::get('ai_seo_prompt_template', 
            "Atue como um Especialista em SEO para E-commerce. Escreva uma meta-descrição persuasiva de no máximo 160 caracteres para o produto abaixo.\n\nRegras:\n1. Comece com um verbo de ação.\n2. Inclua: {product_name} e {category}.\n3. Call to Action no final.\n\nDados do Produto:\nProduto: {product_name}\nCategoria: {category}\nModelo/Tipo: {model} / {type}\nVariante: {variant}"
        );

        $replacements = [
            '{product_name}' => $productName,
            '{category}' => $category,
            '{model}' => $model,
            '{type}' => $type,
            '{variant}' => $variant,
        ];

        $prompt = str_replace(array_keys($replacements), array_values($replacements), $template);
        return $prompt . "\n\nIMPORTANTE: Apenas entregue o resultado final.";
    }

    public function buildFullDescriptionPrompt(array $data): string
    {
        $productName = $data['name'] ?? 'Produto';
        $category = $data['category'] ?? 'Geral';
        $material = $data['material'] ?? '';
        $size = $data['size'] ?? '';

        $variantParts = [];
        if (!empty($data['color'])) $variantParts[] = "Cor: " . $data['color'];
        if (!empty($data['flavor'])) $variantParts[] = "Sabor: " . $data['flavor'];
        $variant = implode(', ', $variantParts);

        $template = \App\Models\StoreSetting::get('ai_description_prompt_template', 
            "Atue como um Copywriter Sênior de E-commerce. Escreva uma descrição de produto completa e envolvente para a página de vendas em formato HTML.\n\nEstrutura Obrigatória (Use tags HTML):\n1. Título: Use <h1> para um título criativo com o nome do produto.\n2. Gancho Emocional: Use <p> para 2-3 frases focadas no problema/solução.\n3. Benefícios: Use <ul> e <li>. Use <strong> para destacar palavras-chave.\n4. Experiência: Use <p> para descrever material ({material}) e variante ({variant}).\n5. Regras Finais: NÃO inclua Chamada para Ação (CTA). NÃO use Markdown (** ou ##). Apenas HTML puro.\n\nDados do Produto:\nNome: {product_name}\nCategoria: {category}\nMaterial/Ingredientes: {material}\nDetalhes da Variante: {variant}\nTamanho: {size}"
        );

        $replacements = [
            '{product_name}' => $productName,
            '{category}' => $category,
            '{material}' => $material,
            '{variant}' => $variant,
            '{size}' => $size,
        ];

        $prompt = str_replace(array_keys($replacements), array_values($replacements), $template);
        return $prompt . "\n\nIMPORTANTE: Apenas entregue o resultado final. Não inicie com 'Claro', 'Aqui está', 'Como copywriter', etc. Vá direto ao texto.";
    }

    public function generateText(string $prompt): string
    {
        $provider = \App\Models\StoreSetting::get('ai_provider', 'gemini');
        Log::info("AiContentService: Starting generation with provider: {$provider}");

        try {
            $result = match ($provider) {
                'openai' => $this->generateOpenAI($prompt),
                'deepseek' => $this->generateDeepSeek($prompt),
                default => $this->generateGemini($prompt),
            };

            Log::info("AiContentService: Result received", ['length' => strlen($result ?? '')]);

            if (!$result) {
                Log::error("AiContentService: Empty result from provider");
                throw new \Exception("A API retornou uma resposta vazia.");
            }

            return $result;

        } catch (\Exception $e) {
            Log::error("AI Generation Exception ({$provider}): " . $e->getMessage());
            throw $e; 
        }
    }

    private function generateGemini(string $prompt): ?string
    {
        $apiKey = \App\Models\StoreSetting::get('gemini_api_key') ?: config('services.gemini.api_key');
        
        if (empty($apiKey)) {
            throw new \Exception('API Key do Gemini não configurada.');
        }

        // Switching to 'gemini-2.5-flash' as requested (High Priority/Efficient)
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        $response = Http::post($url, [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 8192,
            ]
        ]);

        if ($response->successful()) {
            return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
        }

        $error = $response->json()['error']['message'] ?? $response->body();
        throw new \Exception("Google Gemini Error: " . $error);
    }

    private function generateOpenAI(string $prompt): ?string
    {
        $apiKey = \App\Models\StoreSetting::get('openai_api_key');

        if (empty($apiKey)) {
            throw new \Exception('API Key da OpenAI não configurada.');
        }

        $response = Http::withToken($apiKey)->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 1000,
        ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'] ?? null;
        }

        $error = $response->json()['error']['message'] ?? $response->body();
        throw new \Exception("OpenAI Error: " . $error);
    }

    private function generateDeepSeek(string $prompt): ?string
    {
        $apiKey = \App\Models\StoreSetting::get('deepseek_api_key');

        if (empty($apiKey)) {
            throw new \Exception('API Key da DeepSeek não configurada.');
        }

        $response = Http::withToken($apiKey)->post('https://api.deepseek.com/chat/completions', [
            'model' => 'deepseek-chat',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 1000,
        ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'] ?? null;
        }

        $error = $response->json()['error']['message'] ?? $response->body();
        throw new \Exception("DeepSeek Error: " . $error);
    }
}
