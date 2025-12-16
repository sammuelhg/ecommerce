<?php

declare(strict_types=1);

namespace App\View\Components\Blocks;

use App\DTOs\Blocks\BlogGridConfig;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class BlogGrid extends Component
{
    public BlogGridConfig $config;
    public Collection $posts;

    public function __construct(array $data)
    {
        // 1. Hidrata o DTO com as configs do JSON do banco
        $this->config = BlogGridConfig::fromArray($data);

        // 2. Busca os dados reais (Content)
        // Isso permite que o componente seja "arrastado" para qualquer página e funcione sozinho
        // Ensure Post table exists or handle gracefully if not (for now we assume it works as we created the Model)
        $this->posts = Post::with('author') // Eager loading para performance
            ->published()
            ->latest()
            ->take($this->config->limit)
            ->get();
    }

    // Calcula a classe de coluna do Bootstrap dinamicamente
    public function getColumnClass(): string
    {
        // 12 colunas totais. Se colsDesktop = 3, então col-md-4 (12/3 = 4)
        $desktopSpan = intdiv(12, $this->config->colsDesktop);
        $mobileSpan = intdiv(12, $this->config->colsMobile);

        return "col-{$mobileSpan} col-md-{$desktopSpan}";
    }

    public function render(): View
    {
        return view('components.blocks.blog-grid');
    }
}
