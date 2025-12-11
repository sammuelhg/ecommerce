<?php

declare(strict_types=1);

namespace App\DTOs\Integrations;

readonly class TikTokConnectData
{
    public function __construct(
        public string $advertiserId,
        public string $accessToken,
        public string $pixelId,
        public bool $isActive
    ) {}

    public function toArray(): array
    {
        return [
            'advertiser_id' => $this->advertiserId,
            'access_token' => $this->accessToken,
            'pixel_id' => $this->pixelId,
            'is_active' => $this->isActive,
        ];
    }
}
