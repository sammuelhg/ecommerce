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
        $allowedTabs = ['identity', 'colors', 'info', 'ai', 'modals', 'security', 'email'];
        if (!in_array($tab, $allowedTabs)) {
            $tab = 'identity';
        }

        $settings = StoreSetting::all()->pluck('value', 'key');
        
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
            'ai_image_prompt_template' => 'nullable|string',
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
            'email_card_id' => 'nullable|integer'
        ]);

        $dto = StoreSettingsDTO::fromRequest($request);
        
        $this->service->updateSettings($dto);

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
