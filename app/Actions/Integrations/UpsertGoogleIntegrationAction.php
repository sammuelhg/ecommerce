<?php

declare(strict_types=1);

namespace App\Actions\Integrations;

use App\DTOs\Integrations\GoogleConnectData;
use App\Models\Integration;
use App\Services\AdNetworks\GoogleAdsService;
use Exception;

final class UpsertGoogleIntegrationAction
{
    public function __construct(
        private GoogleAdsService $service
    ) {}

    public function execute(GoogleConnectData $data): Integration
    {
        $credentials = $data->toArray();

        // 1. Se estiver ativando, validamos a conexão primeiro
        if ($data->isActive) {
            $isValid = $this->service->validateConnection($credentials);
            
            if (!$isValid) {
                throw new Exception("As credenciais do Google Ads são inválidas ou o Customer ID está mal formatado.");
            }
        }

        // 2. Persistência (Upsert)
        // O Model Integration usa $casts = ['credentials' => 'encrypted:array'] por segurança
        // Note: The model field is 'credentials', not 'config'.
        return Integration::updateOrCreate(
            ['provider' => 'google_ads'],
            [
                'name' => 'Google Ads Principal',
                'credentials' => $credentials,
                'is_active' => $data->isActive,
            ]
        );
    }
}
