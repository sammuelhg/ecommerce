<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use App\Services\Admin\StoreSettingService;
use App\DTOs\Admin\StoreSettingsDTO;

class StoreSettingController extends Controller
{
    public function __construct(
        protected StoreSettingService $service
    ) {}

    public function index($tab = 'identity')
    {
        $allowedTabs = ['identity', 'info', 'ai', 'modals', 'security', 'email'];
        if (!in_array($tab, $allowedTabs)) {
            $tab = 'identity';
        }

        $settings = StoreSetting::all()->mapWithKeys(function ($item) {
             // Fix for localhost URLs in production dump (Handle standard and port 8000 and double port edge case)
             $value = $item->value;
             
             if (is_string($value)) {
                 $value = str_replace(
                    [
                        'http://localhost:8000/:8000', 'https://localhost:8000/:8000', // Double port edge case
                        'http://localhost:8000', 'https://localhost:8000', 
                        'http://localhost', 'https://localhost'
                    ], 
                    '', 
                    $value
                 );
             }

             return [$item->key => $value];
        });
        
        return view('admin.settings.index', [
            'settings' => $settings,
            'certificates' => StoreSetting::get('security_certificates', []),
            'activeTab' => $tab
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_logo' => 'nullable|image|max:2048',
            'email_logo' => 'nullable|image|max:2048',
            'profile_logo' => 'nullable|image|max:2048',
            'footer_logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|mimes:ico,png|max:1024',
            'store_address' => 'nullable|string',
            'store_cnpj' => 'nullable|string',
            'store_phone' => 'nullable|string',
            'google_maps_embed_url' => 'nullable|string',
            'gemini_api_key' => 'nullable|string',
            'openai_api_key' => 'nullable|string',
            'deepseek_api_key' => 'nullable|string',
            'ai_provider' => 'nullable|string|in:gemini,openai,deepseek',
            'ai_image_prompt_template' => 'nullable|string',
            'ai_seo_prompt_template' => 'nullable|string',
            'ai_description_prompt_template' => 'nullable|string',
            'modal_about' => 'nullable|string',
            'modal_careers' => 'nullable|string',
            'modal_contact' => 'nullable|string',
            'modal_returns' => 'nullable|string',
            'modal_faq' => 'nullable|string',
            'modal_privacy' => 'nullable|string',
            'modal_blog' => 'nullable|string',
            'modal_tracking' => 'nullable|string',
            'color_primary' => 'nullable|string',
            'color_secondary' => 'nullable|string',
            'color_accent' => 'nullable|string',
            'color_background' => 'nullable|string',
            'color_category_bar' => 'nullable|string',
            'security_certificates.*' => 'image|max:2048',
            'email_card_id' => 'nullable|integer',
            'smtp_host' => 'nullable|string',
            'smtp_port' => 'nullable|string',
            'smtp_username' => 'nullable|string',
            'smtp_password' => 'nullable|string',
            'smtp_encryption' => 'nullable|string',
            'email_subject_prefix' => 'nullable|string',
            'global_showcase_products' => 'nullable|string', // JSON string
        ]);

        $dto = StoreSettingsDTO::fromRequest($request);
        
        $this->service->updateSettings($dto);



        $tab = $request->input('redirect_tab', 'identity');
        return redirect()->route('admin.settings.index', ['tab' => $tab])->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function removeCertificate(Request $request)
    {
        $path = $request->input('path');
        
        if ($path) {
            $this->service->removeCertificate($path);
        }

        return redirect()->back()->with('success', 'Certificado removido com sucesso!');
    }

    public function resetAiPrompts()
    {
        StoreSetting::set('ai_image_prompt_template', 'Professional e-commerce product photography of {product_name}, {category} category product, {type} type, {model} model, {size} size, {variant}, {material} style. Studio lighting, clean white background, product centered, front view, label visible and readable, high resolution, professional packshot, 8k quality, photorealistic');
        
        StoreSetting::set('ai_seo_prompt_template', "Atue como um Especialista em SEO para E-commerce. Escreva uma meta-descrição persuasiva de no máximo 160 caracteres para o produto abaixo.\n\nRegras:\n1. Comece com um verbo de ação.\n2. Inclua: {product_name} e {category}.\n3. Call to Action no final.\n\nDados do Produto:\nProduto: {product_name}\nCategoria: {category}\nModelo/Tipo: {model} / {type}\nVariante: {variant}");
        
        StoreSetting::set('ai_description_prompt_template', "Atue como um Copywriter Sênior de E-commerce. Escreva uma descrição de produto completa e envolvente para a página de vendas em formato HTML.\n\nEstrutura Obrigatória (Use tags HTML):\n1. Título: Use <h1> para um título criativo com o nome do produto.\n2. Gancho Emocional: Use <p> para 2-3 frases focadas no problema/solução.\n3. Benefícios: Use <ul> e <li>. Use <strong> para destacar palavras-chave.\n4. Experiência: Use <p> para descrever material ({material}) e variante ({variant}).\n5. Regras Finais: NÃO inclua Chamada para Ação (CTA). NÃO use Markdown (** ou ##). Apenas HTML puro.\n\nDados do Produto:\nNome: {product_name}\nCategoria: {category}\nMaterial/Ingredientes: {material}\nDetalhes da Variante: {variant}\nTamanho: {size}");

        return redirect()->back()->with('success', 'Prompts resetados para o padrão original!');
    }
    public function previewEmail($type)
    {
        switch ($type) {
            case 'welcome':
                $user = new \App\Models\User([
                    'name' => 'Usuário Exemplo',
                    'email' => 'usuario@exemplo.com'
                ]);
                
                // Produtos de exemplo
                $products = \App\Models\Product::inRandomOrder()->take(3)->get();
                if ($products->isEmpty()) {
                    $products = collect([
                        new \App\Models\Product(['name' => 'Produto Exemplo 1', 'price' => 99.90, 'slug' => 'produto-1', 'image' => '']),
                        new \App\Models\Product(['name' => 'Produto Exemplo 2', 'price' => 149.90, 'slug' => 'produto-2', 'image' => '']),
                    ]);
                }

                return view('emails.welcome', [
                    'user' => $user,
                    'password' => 'Senha123',
                    'loginUrl' => route('login'),
                    'products' => $products,
                    'subject' => 'Bem-vindo à ' . config('app.name')
                ]);

            case 'reset':
                return view('emails.password-reset-request', [
                    'resetUrl' => url(route('password.reset', ['token' => 'token-exemplo', 'email' => 'user@example.com'], false)),
                    'subject' => 'Redefinição de Senha'
                ]);

            case 'reset-confirmation':
                return view('emails.password-reset-confirmation', [
                    'newPassword' => 'NovaSenha123',
                    'loginUrl' => route('login'),
                    'subject' => 'Senha Alterada com Sucesso'
                ]);

            default:
                abort(404);
        }
    }
}
