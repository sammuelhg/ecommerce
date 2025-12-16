<?php

namespace App\Cms\Blocks;

use App\Cms\Contracts\PageBlockInterface;
use Illuminate\Support\Facades\View;

class HeroBlock implements PageBlockInterface
{
    public function __construct(
        public string $title = '',
        public string $subtitle = '',
        public string $image = '',
        public string $layout = 'center'
    ) {}

    public static function type(): string
    {
        return 'hero';
    }

    public static function label(): string
    {
        return 'Banner Hero';
    }

    public function toArray(): array
    {
        return [
            'type' => self::type(),
            'data' => [
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'image' => $this->image,
                'layout' => $this->layout,
            ],
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['data']['title'] ?? '',
            subtitle: $data['data']['subtitle'] ?? '',
            image: $data['data']['image'] ?? '',
            layout: $data['data']['layout'] ?? 'center'
        );
    }

    public function render(): string
    {
        return view('cms.blocks.hero', ['data' => $this->toArray()['data']])->render();
    }
}
