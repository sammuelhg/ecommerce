<?php

declare(strict_types=1);

namespace App\Services\AdNetworks;

use App\Interfaces\AdNetworkInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class MetaAdsService implements AdNetworkInterface
{
    private const BASE_URL = 'https://graph.facebook.com/v19.0';

    public function validateConnection(array $credentials): bool
    {
        // Simulação de check de token (na prática faria um call para /me)
        // Aqui garantimos que não estamos salvando lixo
        if (empty($credentials['access_token'])) {
            return false;
        }

        try {
            // Exemplo real: verificar se o token é válido
            /* $response = Http::get(self::BASE_URL . '/me', [
                'access_token' => $credentials['access_token']
            ]);
            return $response->successful();
            */
            return true; 
        } catch (\Exception $e) {
            Log::error("Meta Ads Connection Error: " . $e->getMessage());
            return false;
        }
    }

    public function sendEvent(string $eventName, array $payload): void
    {
        $credentials = $payload['credentials'] ?? null;
        $eventData = $payload['event_data'] ?? [];

        if (!$credentials || empty($credentials['access_token']) || empty($credentials['pixel_id'])) {
            // Se as credenciais não vierem no payload (estranho mas possível), abortamos.
            return;
        }

        $pixelId = $credentials['pixel_id'];
        $accessToken = $credentials['access_token'];

        // Monta o corpo da requisição CAPI
        $body = [
            'data' => [$eventData],
        ];

        // Se houver código de teste (para debug no Events Manager), adiciona
        if (!empty($credentials['test_event_code'])) {
            $body['test_event_code'] = $credentials['test_event_code'];
        }

        // POST https://graph.facebook.com/{version}/{pixel_id}/events
        $response = Http::withToken($accessToken)
            ->post(self::BASE_URL . "/{$pixelId}/events", $body);

        if ($response->failed()) {
            throw new \Exception("Meta Ads API Error: " . $response->body());
        }
    }
}
