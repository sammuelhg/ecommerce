<?php

namespace App\Cms\Blocks;

use Illuminate\Contracts\Support\Arrayable;

abstract class BaseBlock implements Arrayable
{
    public string $id;
    
    public function __construct(string $id = null)
    {
        $this->id = $id ?? uniqid('block_', true);
    }

    abstract public static function type(): string;
    abstract public static function label(): string;
    
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => static::type(),
            'data' => $this->data(),
        ];
    }

    abstract protected function data(): array;

    public static function fromArray(array $data): static
    {
        $instance = new static($data['id'] ?? null);
        $instance->fill($data['data'] ?? []);
        return $instance;
    }

    abstract public function fill(array $data): void;
}
