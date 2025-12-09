<?php


declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailPreviewController extends Controller
{
    public function index()
    {
        return view('admin.emails.dashboard');
    }

    public function previewType($type)
    {
        switch ($type) {
            case 'welcome':
                $user = auth()->user() ?? new \App\Models\User([
                    'name' => 'Visitante', 
                    'email' => 'teste@teste.com'
                ]);
                return view('emails.welcome', [
                    'user' => $user,
                    'password' => 'senha123', // Mock password
                    'loginUrl' => route('login')
                ]);
            
            case 'reset':
                return view('emails.password-reset-request', [
                    'token' => 'xyz-preview-token', 
                    'email' => 'teste@teste.com',
                    'resetUrl' => url('password/reset/xyz-preview-token')
                ]);
            
            case 'reset-confirmation':
                return view('emails.password-reset-confirmation', [
                    'newPassword' => 'nova-senha-segura-123',
                    'loginUrl' => route('login')
                ]);

            case 'newsletter-welcome':
                return view('emails.newsletter.welcome');

            case 'highlights':
                // Mock Data Object matching the view expectation
                $data = (object) [
                    'title' => 'Destaques da Semana',
                    'subtitle' => 'Confira os produtos mais vendidos e as novidades que acabaram de chegar.',
                    'imageUrl' => 'https://via.placeholder.com/600x300/ffd700/000000?text=Novidades+LosFit', // Sample Image
                    'ctaText' => 'Ver Coleção Completa',
                    'ctaUrl' => route('shop.index'),
                    'items' => [
                        [
                            'name' => 'Camiseta Black Edition',
                            'price' => 'R$ 89,90',
                            'image' => 'https://via.placeholder.com/100',
                            'url' => '#'
                        ],
                        [
                            'name' => 'Boné LosFit Trucker',
                            'price' => 'R$ 59,90',
                            'image' => 'https://via.placeholder.com/100',
                            'url' => '#'
                        ]
                    ]
                ];
                return view('emails.highlights', compact('data'));

            case 'cards':
                $cards = \App\Models\EmailCard::all();
                return view('admin.emails.preview', compact('cards'));

            case 'reply':
                 $replyPreview = [
                    'subject' => 'RE: Dúvida sobre o pedido #1234',
                    'body' => "Olá Maria,\n\nObrigado pelo seu contato. Verifiquei aqui e seu pedido já foi despachado.\nO código de rastreio é: BR123456789.\n\nQualquer dúvida, estou à disposição.",
                ];
                
                // Get Default Card for the Preview
                $defaultCard = \App\Models\EmailCard::getDefault();

                return view('admin.emails.preview', [
                    'cards' => [],
                    'replyPreview' => $replyPreview,
                    'unsubScenarios' => [],
                    'showReply' => true,
                    'defaultCard' => $defaultCard // Pass default card explicitly
                ]);

            case 'unsubscribe':
                // Single Realistic Scenario
                $unsubScenarios = [
                    [
                        'type' => 'Campanha Real (Simulação)',
                        'campaign_name' => 'Black Friday 2024',
                        'subscriber_email' => 'cliente.real@email.com'
                    ]
                ];
                
                return view('admin.emails.preview', [
                    'cards' => [],
                    'unsubScenarios' => $unsubScenarios,
                    'showUnsubscribe' => true,
                    'defaultCard' => \App\Models\EmailCard::getDefault()
                ]);

            default:
                abort(404);
        }
    }
}
