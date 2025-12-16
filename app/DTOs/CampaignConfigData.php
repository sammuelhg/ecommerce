<?php

declare(strict_types=1);

namespace App\DTOs;


class CampaignConfigData
{
    public function __construct(
        public int $sign_card_id,
        public array $product_ids,
        public string $email_content,
        public array $sending_rules,
        public bool $is_active = true,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            sign_card_id: (int) $data['sign_card_id'],
            product_ids: (array) $data['product_ids'],
            email_content: (string) $data['email_content'],
            sending_rules: (array) $data['sending_rules'],
            is_active: (bool) ($data['is_active'] ?? true),
        );
    }
}
