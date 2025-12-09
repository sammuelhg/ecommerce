<?php

declare(strict_types=1);

namespace App\DTOs;

use DateTimeInterface;

class CampaignDTO
{
    public function __construct(
        public readonly string $subject,
        public readonly string $body,
        public readonly \App\Enums\CampaignStatus $status = \App\Enums\CampaignStatus::DRAFT,
        public readonly ?DateTimeInterface $scheduled_at = null,
        public readonly ?int $id = null,
        public readonly ?int $email_card_id = null,
        public readonly array $product_ids = [],
        public readonly ?string $promo_image_url = null,
        public readonly bool $show_promo_image_in_email = false,
    ) {}

    public static function fromLivewire(array $data): self
    {
        return new self(
            subject: $data['subject'] ?? '',
            body: $data['body'] ?? '',
            status: $data['status'] ?? \App\Enums\CampaignStatus::DRAFT,
            scheduled_at: $data['scheduled_at'] ?? null,
            id: $data['id'] ?? null,
            email_card_id: $data['email_card_id'] ?? null,
            product_ids: $data['product_ids'] ?? [],
            promo_image_url: $data['promoImageUrl'] ?? null,
            show_promo_image_in_email: $data['showPromoImageInEmail'] ?? false,
        );
    }
}
