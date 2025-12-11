<?php

declare(strict_types=1);

namespace App\DTOs\Integrations;

readonly class MetaConnectData
{
    public function __construct(
        public string $adAccountId,
        public string $pixelId,
        public string $accessToken,
        public bool $isActive
    ) {}

    /**
     * Converte para array seguro para persistência
     */
    public function toArray(): array
    {
        return [
            'ad_account_id' => $this->adAccountId,
            'pixel_id' => $this->pixelId,
            'access_token' => $this->accessToken,
        ];
    }
}
