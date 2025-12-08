<?php

declare(strict_types=1);

namespace App\DTOs\Auth;

use App\DTOs\BaseDTO;

class RegisterUserDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        // Adicione aqui campos extras se houver (ex: phone, marketing_opt_in)
    ) {}
}
