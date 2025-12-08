<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class HighlightsDTO
{
    public function __construct(
        public string $title,
        public string $subtitle,
        public string $imageUrl, // Full URL
        public string $ctaText,
        public string $ctaUrl,
        public array $items = [] // Optional list of items/products
    ) {}
}
