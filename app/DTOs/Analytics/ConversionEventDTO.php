<?php

declare(strict_types=1);

namespace App\DTOs\Analytics;

use Illuminate\Http\Request;

class ConversionEventDTO
{
    public function __construct(
        public readonly string $order_id,
        public readonly float $total_value,
        public readonly ?string $campaign_id = null, // ID da campanha interna
        public readonly ?string $source_type = null, // 'email_campaign', 'organic', 'meta_ads'
        public readonly ?string $utm_source = null,
        public readonly ?string $customer_email = null // Para correspondência avançada (CAPI)
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            order_id: (string) $request->validated('order_id'),
            total_value: (float) $request->validated('value'),
            campaign_id: $request->validated('campaign_id'),
            source_type: $request->validated('source_type') ?? 'organic',
            utm_source: $request->validated('utm_source'),
            customer_email: $request->validated('customer_email')
        );
    }
}
