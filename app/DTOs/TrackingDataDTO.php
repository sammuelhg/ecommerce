<?php

declare(strict_types=1);

namespace App\DTOs;

use Illuminate\Http\Request;

class TrackingDataDTO
{
    public function __construct(
        public readonly ?string $utm_source = null,
        public readonly ?string $utm_medium = null,
        public readonly ?string $utm_campaign = null,
        public readonly ?string $utm_term = null,
        public readonly ?string $utm_content = null
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            utm_source: $request->input('utm_source'),
            utm_medium: $request->input('utm_medium'),
            utm_campaign: $request->input('utm_campaign'),
            utm_term: $request->input('utm_term'),
            utm_content: $request->input('utm_content')
        );
    }
}
