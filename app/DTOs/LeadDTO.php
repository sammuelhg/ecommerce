<?php

declare(strict_types=1);

namespace App\DTOs;

class LeadDTO
{
    public function __construct(
        public readonly string $email,
        public readonly ?string $name = null,
        public readonly ?string $phone = null,
        public readonly ?string $source = null,
        public readonly \App\Enums\LeadStatus $status = \App\Enums\LeadStatus::ACTIVE,
        public readonly ?string $utm_source = null,
        public readonly ?string $utm_medium = null,
        public readonly ?string $utm_campaign = null,
        public readonly ?string $utm_content = null,
        public readonly array $meta = []
    ) {}
}
