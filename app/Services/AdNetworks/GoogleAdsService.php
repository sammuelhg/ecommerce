<?php

declare(strict_types=1);

namespace App\Services\AdNetworks;

use App\DTOs\Integrations\GoogleConnectData;
use App\Interfaces\AdNetworkInterface;
use Illuminate\Support\Facades\Log;

class GoogleAdsService implements AdNetworkInterface
{
    /**
     * Simula a validação das credenciais junto à API do Google.
     * Note: AdNetworkInterface defines `validateConnection(array $credentials): bool`
     * We will accept array here to comply with interface, or check usage.
     * The Interface defined earlier: public function validateConnection(array $credentials): bool;
     */
    public function validateConnection(array $credentials): bool
    {
        $customerId = $credentials['customer_id'] ?? '';
        $developerToken = $credentials['developer_token'] ?? '';

        // Em produção, faríamos uma chamada real à API "GetCustomer"
        if (empty($customerId) || empty($developerToken)) {
            return false;
        }

        // Validação básica de formato (Exemplo: Customer ID deve ter números e traços)
        // Aceita formatos com ou sem traços: 123-456-7890 ou 1234567890
        if (!preg_match('/^[\d-]+$/', $customerId)) {
            return false;
        }

        return true;
    }

    /**
     * Placeholder para envio de eventos Offline (Server-side tracking).
     */
    public function sendEvent(string $eventName, array $payload): void
    {
        // TODO: Implement Google Ads Offline Conversions API
        // Doc: https://developers.google.com/google-ads/api/docs/conversions/upload-clicks
        Log::info('Google Ads Event Dispatched (Simulation)', ['event' => $eventName, 'payload' => $payload]);
    }
}
