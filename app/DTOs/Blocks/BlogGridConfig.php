<?php

declare(strict_types=1);

namespace App\DTOs\Blocks;

readonly class BlogGridConfig
{
    public function __construct(
        // Título do Post
        public string $titleSize = 'h5', // h1 a h6
        public string $titleColor = 'text-dark', // classes bootstrap: text-primary, text-danger...
        
        // Subtítulo (Resumo)
        public string $subtitleSize = 'small',
        public string $subtitleColor = 'text-muted',
        
        // Autor
        public bool $showAvatar = true,
        public string $authorColor = 'text-secondary',
        
        // Data
        public string $dateFormat = 'human', // 'human' (há 2 dias) ou 'date' (12/12/2024)
        
        // Layout
        public int $colsDesktop = 3, // 1, 2, 3, 4, 6
        public int $colsMobile = 1,  // 1 ou 2
        public int $limit = 6        // Quantos posts carregar
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            titleSize: $data['title_size'] ?? 'h5',
            titleColor: $data['title_color'] ?? 'text-dark',
            subtitleSize: $data['subtitle_size'] ?? 'small',
            subtitleColor: $data['subtitle_color'] ?? 'text-muted',
            showAvatar: $data['show_avatar'] ?? true,
            authorColor: $data['author_color'] ?? 'text-secondary',
            dateFormat: $data['date_format'] ?? 'human',
            colsDesktop: (int) ($data['cols_desktop'] ?? 3),
            colsMobile: (int) ($data['cols_mobile'] ?? 1),
            limit: (int) ($data['limit'] ?? 6)
        );
    }
}
