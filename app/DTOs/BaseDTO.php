<?php

declare(strict_types=1);

namespace App\DTOs;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

abstract class BaseDTO implements Arrayable, JsonSerializable
{
    // Permite preencher o DTO com um array (útil para hidratar dados do Request)
    public static function fromArray(array $data): static
    {
        return new static(...$data);
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
    
    public function toJson(int $options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
