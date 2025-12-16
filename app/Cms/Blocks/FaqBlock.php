<?php

namespace App\Cms\Blocks;

use App\Cms\Contracts\PageBlockInterface;
use Illuminate\Support\Facades\View;

class FaqBlock implements PageBlockInterface
{
    public function __construct(
        public string $title = 'Perguntas Frequentes',
        public array $items = []
    ) {}

    public static function type(): string
    {
        return 'faq';
    }

    public static function label(): string
    {
        return 'FAQ (Perguntas)';
    }

    public function toArray(): array
    {
        return [
            'type' => self::type(),
            'data' => [
                'title' => $this->title,
                'items' => $this->items,
            ],
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['data']['title'] ?? 'Perguntas Frequentes',
            items: $data['data']['items'] ?? []
        );
    }

    public function render(): string
    {
        return view('cms.blocks.faq', ['data' => $this->toArray()['data']])->render();
    }
}
