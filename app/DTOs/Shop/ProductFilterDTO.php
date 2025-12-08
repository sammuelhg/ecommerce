<?php

declare(strict_types=1);

namespace App\DTOs\Shop;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class ProductFilterDTO extends BaseDTO
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?string $categorySlug = null,
        public readonly ?float $minPrice = null,
        public readonly ?float $maxPrice = null,
        public readonly ?string $sortOrder = 'newest', // newest, price_asc, price_desc
        public readonly array $categoryIds = [], // Helper to pass resolved IDs if needed
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            search: $request->input('q') ?? $request->input('search'),
            categorySlug: $request->input('category'), // If coming from query param
            minPrice: $request->input('min_price') ? (float)$request->input('min_price') : null,
            maxPrice: $request->input('max_price') ? (float)$request->input('max_price') : null,
            sortOrder: $request->input('sort', 'newest')
        );
    }
}
