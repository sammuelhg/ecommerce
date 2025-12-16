<?php

namespace App\Cms\Blocks;

use App\Cms\Contracts\PageBlockInterface;
use Illuminate\Support\Facades\View;

class ContactBlock implements PageBlockInterface
{
    public function __construct(
        public string $email = '',
        public bool $showForm = true
    ) {}

    public static function type(): string
    {
        return 'contact';
    }

    public static function label(): string
    {
        return 'Bloco de Contato';
    }

    public function toArray(): array
    {
        return [
            'type' => self::type(),
            'data' => [
                'email' => $this->email,
                'show_form' => $this->showForm,
            ],
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['data']['email'] ?? '',
            showForm: $data['data']['show_form'] ?? true
        );
    }

    public function render(): string
    {
        return view('cms.blocks.contact', ['data' => $this->toArray()['data']])->render();
    }
}
