<?php

namespace App\Livewire\Cms;

use App\DTOs\Blocks\BlogGridConfig;
use App\Domains\Content\Models\CmsComponent;
use Livewire\Component;

class ComponentBuilder extends Component
{
    public ?CmsComponent $component = null;
    
    // Config Properties (Mapped to DTO)
    public $name = 'Meu Novo Componente';
    public $titleSize = 'h5';
    public $titleColor = 'text-dark';
    public $subtitleSize = 'small';
    public $subtitleColor = 'text-muted';
    public $showAvatar = true;
    public $authorColor = 'text-secondary';
    public $dateFormat = 'human';
    public $colsDesktop = 3;
    public $colsMobile = 1;
    public $limit = 6;

    public function mount($component = null)
    {
        if ($component) {
            $this->component = CmsComponent::find($component);
            if ($this->component) {
                $this->name = $this->component->name;
                $config = $this->component->data;
                $this->fillFromConfig($config);
            }
        }
    }

    public function fillFromConfig($data)
    {
        $this->titleSize = $data['title_size'] ?? 'h5';
        $this->titleColor = $data['title_color'] ?? 'text-dark';
        $this->subtitleSize = $data['subtitle_size'] ?? 'small';
        $this->subtitleColor = $data['subtitle_color'] ?? 'text-muted';
        $this->showAvatar = $data['show_avatar'] ?? true;
        $this->authorColor = $data['author_color'] ?? 'text-secondary';
        $this->dateFormat = $data['date_format'] ?? 'human';
        $this->colsDesktop = $data['cols_desktop'] ?? 3;
        $this->colsMobile = $data['cols_mobile'] ?? 1;
        $this->limit = $data['limit'] ?? 6;
    }

    public function getPreviewConfigProperty()
    {
        return [
            'title_size' => $this->titleSize,
            'title_color' => $this->titleColor,
            'subtitle_size' => $this->subtitleSize,
            'subtitle_color' => $this->subtitleColor,
            'show_avatar' => $this->showAvatar,
            'author_color' => $this->authorColor,
            'date_format' => $this->dateFormat,
            'cols_desktop' => $this->colsDesktop,
            'cols_mobile' => $this->colsMobile,
            'limit' => $this->limit,
        ];
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'limit' => 'required|integer|min:1|max:12',
        ]);

        $data = $this->previewConfig;

        if ($this->component) {
            $this->component->update([
                'name' => $this->name,
                'data' => $data,
            ]);
        } else {
            $this->component = CmsComponent::create([
                'name' => $this->name,
                'type' => 'blog_grid',
                'data' => $data,
            ]);
            // Redirect to edit mode to keep context or just notify
        }

        session()->flash('success', 'Componente salvo com sucesso!');
    }

    public function render()
    {
        return view('livewire.cms.component-builder')->layout('layouts.admin');
    }
}
