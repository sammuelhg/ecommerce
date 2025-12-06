<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreSettingController extends Controller
{
    public function index()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');
        
        return view('admin.settings.index', [
            'settings' => $settings,
            'certificates' => StoreSetting::get('security_certificates', [])
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_logo' => 'nullable|image|max:2048',
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
            'color_primary' => 'nullable|string',
            'color_secondary' => 'nullable|string',
            'color_accent' => 'nullable|string',
            'color_background' => 'nullable|string',
            'color_category_bar' => 'nullable|string',
            'security_certificates.*' => 'image|max:2048'
        ]);

        // Text Settings
        $textFields = [
            'store_address', 
            'store_cnpj', 
            'store_phone',
            'google_maps_embed_url',
            'ai_image_prompt_template',
            'modal_about',
            'modal_careers',
            'modal_contact',
            'modal_returns',
            'modal_faq',
            'color_primary', 
            'color_secondary', 
            'color_accent', 
            'color_background',
            'color_category_bar',
            // Email Settings
            'email_card_id'
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                StoreSetting::set($field, $request->input($field), str_contains($field, 'color') ? 'color' : 'text');
            }
        }

        // Logo Upload
        if ($request->hasFile('store_logo')) {
            $path = $request->file('store_logo')->store('uploads/settings', 'public');
            StoreSetting::set('store_logo', Storage::url($path), 'image');
        }

        // Certificates Upload (Append to existing)
        if ($request->hasFile('security_certificates')) {
            $currentCertificates = StoreSetting::get('security_certificates', []);
            
            foreach ($request->file('security_certificates') as $file) {
                $path = $file->store('uploads/settings/certificates', 'public');
                $currentCertificates[] = Storage::url($path);
            }
            
            StoreSetting::set('security_certificates', $currentCertificates, 'json');
        }

        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function removeCertificate(Request $request)
    {
        $path = $request->input('path');
        $certificates = StoreSetting::get('security_certificates', []);
        
        $certificates = array_filter($certificates, fn($c) => $c !== $path);
        
        // Optional: Delete file from storage if needed
        // Storage::disk('public')->delete(str_replace('/storage/', '', $path));

        StoreSetting::set('security_certificates', array_values($certificates), 'json');

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
