<?php

declare(strict_types=1);

namespace App\DTOs\Integrations;

readonly class GoogleConnectData
{
    public function __construct(
        public string $customerId,
        public string $developerToken,
        public string $conversionActionId,
        public bool $isActive
    ) {}

    public function toArray(): array
    {
        return [
            'customer_id' => $this->customerId,
            'developer_token' => $this->developerToken,
            'conversion_action_id' => $this->conversionActionId,
            'is_active' => $this->isActive,
        ];
    }
}
