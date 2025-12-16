<?php

namespace App\Cms\Blocks;

use App\Cms\Contracts\PageBlockInterface;
use Illuminate\Support\Facades\View;

class TextBlock implements PageBlockInterface
{
    public function __construct(
        public string $title = '',
        public string $content = '',
        public string $alignment = 'left'
    ) {}

    public static function type(): string
    {
        return 'text';
    }

    public static function label(): string
    {
        return 'Texto e Conteúdo';
    }

    public function toArray(): array
    {
        return [
            'type' => self::type(),
            'data' => [
                'title' => $this->title,
                'content' => $this->content,
                'alignment' => $this->alignment,
            ],
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['data']['title'] ?? '',
            content: $data['data']['content'] ?? '',
            alignment: $data['data']['alignment'] ?? 'left'
        );
    }

    public function render(): string
    {
        // For now returning simple HTML, can be moved to blade later
        // reusing the logic from page.blade.php but encapsulated here
        // Ideally we return view('components.cms.blocks.text', ['block' => $this])
        // But for speed we will inline the HTML generation similar to the previous view or just a stub
        // The user request example showed View::make, so let's stick to the pattern but maybe inline for simplicity if no component exists yet
        
        // Actually, let's stick to the Plan: "Add render() method to return View components."
        // I'll create a generic view renderer for now to keep it compatible with existing page.blade.php logic
        // But wait, the previous page.blade.php iterated and did if/else.
        // The NEW page.blade.php should iterate and call $block->render().
        
        return view('cms.blocks.text', ['data' => $this->toArray()['data']])->render();
    }
}
