<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class FormData
{
    public function __construct(
        public string $title,
        public array $structure // The Builder JSON
    ) {}
}
