<?php

declare(strict_types=1);

namespace App\Actions\Campaign\Tracking;

use App\Domains\Marketing\Models\CampaignClick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Objetivo: Rastrear o clique no e-mail e iniciar a sessão de atribuição.
 * Pilar 2 (Completude): "O sistema atira... mas não relata". Agora relata o clique.
 */
class TrackEmailClickAction
{
    /**
     * @param string $url Link de destino
     * @param int $campaignId ID da campanha
     * @param int|null $subscriberId ID do assinante (se identificado)
     * @param int|null $emailId ID do e-mail específico na sequência
     * @param Request|null $request Para capturar IP/UserAgent
     */
    public function execute(string $url, int $campaignId, ?int $subscriberId = null, ?int $emailId = null, ?Request $request = null): void
    {
        // 1. Persistência do Clique (Rastreabilidade)
        CampaignClick::create([
            'campaign_id' => $campaignId,
            'newsletter_subscriber_id' => $subscriberId,
            'campaign_email_id' => $emailId,
            'url' => $url,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);

        // 2. Início da Sessão de Atribuição (Conversion Attribution Window)
        // Isso garante que se o usuário comprar depois, saberemos de onde veio.
        Session::put('attribution', [
            'campaign_id' => $campaignId,
            'source_type' => 'email_campaign',
            'timestamp' => now()->timestamp,
        ]);
        
        // Também persistimos UTMs padrão se não existirem, para compatibilidade com GA
        if (!Session::has('utm_campaign')) {
            Session::put('utm_campaign', (string) $campaignId);
            Session::put('utm_source', 'email');
            Session::put('utm_medium', 'newsletter');
        }
    }
}
