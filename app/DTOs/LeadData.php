<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\LeadStatus;

readonly class LeadData
{
    public function __construct(
        public string $email,
        public ?string $name = null,
        public ?string $phone = null,
        public ?string $source = null,
        public ?LeadStatus $status = LeadStatus::NEW,
        public array $meta = [],
        public ?string $utm_source = null,
        public ?string $utm_medium = null,
        public ?string $utm_campaign = null,
        public ?string $utm_content = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            name: $data['name'] ?? null,
            phone: $data['phone'] ?? null,
            source: $data['source'] ?? null,
            status: isset($data['status']) ? LeadStatus::tryFrom($data['status']) : LeadStatus::NEW,
            meta: $data['meta'] ?? [],
            utm_source: $data['utm_source'] ?? null,
            utm_medium: $data['utm_medium'] ?? null,
            utm_campaign: $data['utm_campaign'] ?? null,
            utm_content: $data['utm_content'] ?? null,
        );
    }
}
