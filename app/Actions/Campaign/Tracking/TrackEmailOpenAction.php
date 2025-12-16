<?php

declare(strict_types=1);

namespace App\Actions\Campaign\Tracking;

use App\Models\CampaignOpen;
use App\DTOs\Tracking\PixelEventDTO;
use Illuminate\Support\Facades\Log;

class TrackEmailOpenAction
{
    public function execute(PixelEventDTO $data): void
    {
        // 1. Validar integridade básica
        if (!$data->campaign_id || !$data->contact_id) {
            Log::warning("Tentativa de rastreamento de pixel incompleta", (array) $data);
            return;
        }

        // 2. Anti-Zombie / Idempotência: Verificar se já foi registrado recentemente 
        // (Opcional: dependendo da regra de negócio, podemos querer registrar apenas o primeiro open ou todos)
        // Aqui assumimos registro único por campanha/usuario para evitar flood, ou apenas logar.
        
        $exists = CampaignOpen::where('newsletter_campaign_id', $data->campaign_id)
            ->where('newsletter_subscriber_id', $data->contact_id)
            ->where('newsletter_email_id', $data->email_id)
            ->exists();

        if ($exists) {
            // Se já abriu, talvez atualizar 'last_opened_at' se o modelo suportar, ou ignorar.
            return;
        }

        // 3. Registrar no banco
        try {
            CampaignOpen::create([
                'newsletter_campaign_id' => $data->campaign_id,
                'newsletter_subscriber_id' => $data->contact_id,
                'newsletter_email_id' => $data->email_id,
                'ip_address' => $data->ip_address,
                'user_agent' => $data->user_agent,
            ]);

            // 4. Log para auditoria
            Log::channel('daily')->info("Email aberto: Campanha {$data->campaign_id} por Contato {$data->contact_id}");

        } catch (\Exception $e) {
            Log::error("Erro ao registrar abertura de email: " . $e->getMessage());
        }
    }
}
