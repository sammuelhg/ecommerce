<?php

declare(strict_types=1);

namespace App\DTOs\Cart;

use App\DTOs\BaseDTO;

class CartItemDTO extends BaseDTO
{
    public function __construct(
        public readonly int $productId,
        public readonly int $quantity,
        public readonly ?float $price = null,
        public readonly array $attributes = [],
    ) {}
}
