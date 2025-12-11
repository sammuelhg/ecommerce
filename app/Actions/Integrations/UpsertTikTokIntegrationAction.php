<?php

declare(strict_types=1);

namespace App\Actions\Integrations;

use App\DTOs\Integrations\TikTokConnectData;
use App\Models\Integration;
use App\Services\AdNetworks\TikTokAdsService;
use Exception;

final class UpsertTikTokIntegrationAction
{
    public function __construct(
        private TikTokAdsService $service
    ) {}

    public function execute(TikTokConnectData $data): Integration
    {
        $credentials = $data->toArray();

        // 1. Validation if active
        if ($data->isActive) {
            $isValid = $this->service->validateConnection($credentials);
            
            if (!$isValid) {
                throw new Exception("As credenciais do TikTok Ads são inválidas ou incompletas.");
            }
        }

        // 2. Persistence
        return Integration::updateOrCreate(
            ['provider' => 'tiktok_ads'],
            [
                'name' => 'TikTok Ads Principal',
                'credentials' => $credentials,
                'is_active' => $data->isActive,
            ]
        );
    }
}
