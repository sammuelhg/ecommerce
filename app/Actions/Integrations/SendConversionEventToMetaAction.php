<?php

declare(strict_types=1);

namespace App\Actions\Integrations;

use App\DTOs\Analytics\ConversionEventDTO;
use App\Domains\Shared\Models\Integration;
use App\Services\AdNetworks\MetaAdsService;
use Illuminate\Support\Facades\Log;

class SendConversionEventToMetaAction
{
    public function __construct(
        protected MetaAdsService $service
    ) {}

    public function execute(ConversionEventDTO $data): void
    {
        // 1. Busca a integração ativa do Meta Ads
        $integration = Integration::where('provider', 'meta_ads')
            ->where('is_active', true)
            ->first();

        // Se não tiver integração ativa, não faz nada (fail silently)
        if (!$integration) {
            return;
        }

        $credentials = $integration->credentials;
        
        // Validação mínima das credenciais necessárias
        if (empty($credentials['access_token']) || empty($credentials['pixel_id'])) {
            Log::warning('Integração Meta Ads incompleta: Token ou Pixel ID ausentes.');
            return;
        }

        // 2. Prepara o Payload para o Serviço
        // Incluímos as credenciais no payload pois a interface AdNetworkInterface não prevê injeção de config
        $payload = [
            'credentials' => $credentials,
            'event_data' => [
                'event_name' => 'Purchase',
                'event_time' => time(),
                'action_source' => 'website',
                'user_data' => [
                    // Hash SHA256 do email normalizado (trim + lowercase)
                    'em' => $data->customer_email ? hash('sha256', strtolower(trim($data->customer_email))) : null,
                    // Poderíamos adicionar telefone (ph) se estivesse no DTO
                ],
                'custom_data' => [
                    'currency' => 'BRL',
                    'value' => $data->total_value,
                    'order_id' => $data->order_id,
                ],
            ]
        ];

        try {
            $this->service->sendEvent('Purchase', $payload);
        } catch (\Exception $e) {
            // Loga o erro mas não quebra o fluxo de compra/analytics
            Log::error("Falha ao enviar conversão para Meta Ads: " . $e->getMessage());
        }
    }
}
