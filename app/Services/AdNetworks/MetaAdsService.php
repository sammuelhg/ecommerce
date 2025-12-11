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
        // Implementação futura do CAPI (Conversions API)
    }
}
