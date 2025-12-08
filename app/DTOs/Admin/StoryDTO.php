<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class StoryDTO
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $subtitle,
        public readonly ?UploadedFile $image,
        public readonly ?string $link_url,
        public readonly ?string $expires_at,
        public readonly bool $is_active,
        public readonly int $sort_order,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->input('title'),
            subtitle: $request->input('subtitle'),
            image: $request->file('image'),
            link_url: $request->input('link_url'),
            expires_at: $request->input('expires_at'), // Logic for default 24h can be later or handling null
            is_active: (bool) $request->input('is_active', true),
            sort_order: (int) $request->input('sort_order', 0),
        );
    }
}
