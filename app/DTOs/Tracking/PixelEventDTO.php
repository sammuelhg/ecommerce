<?php

declare(strict_types=1);

namespace App\DTOs\Tracking;

use Illuminate\Http\Request;

class PixelEventDTO
{
    public function __construct(
        public readonly string $campaign_id,
        public readonly string $contact_id, // maps to subscriber_id
        public readonly ?string $email_id = null,
        public readonly ?string $ip_address = null,
        public readonly ?string $user_agent = null
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            campaign_id: $request->input('campaign_id') ?? $request->input('c'),
            contact_id: $request->input('contact_id') ?? $request->input('u'),
            email_id: $request->input('email_id') ?? $request->input('e'),
            ip_address: $request->ip(),
            user_agent: $request->userAgent()
        );
    }
}
