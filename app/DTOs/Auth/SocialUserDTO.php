<?php

declare(strict_types=1);

namespace App\DTOs\Auth;

use App\DTOs\BaseDTO;

class SocialUserDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $providerId,
        public readonly string $providerName,
        public readonly ?string $avatar = null,
    ) {}
}
