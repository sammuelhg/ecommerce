<?php

namespace App\Livewire\Cms;

use App\Domains\Content\Models\Page;
use App\Actions\Cms\UpdatePageContentAction;
use Illuminate\Support\Str;
use Livewire\Component;

class PageBuilder extends Component
{
    public ?Page $page = null;
    
    // Page Properties
    public $title = '';
    public $slug = '';
    public $meta_title = '';
    public $meta_description = '';
    public $is_active = true;

    // Blocks
    public $blocks = []; // Array of ['id' => ..., 'type' => ..., 'data' => ...]

    public function mount($pageIdentifier = null)
    {
        if ($pageIdentifier) {
            $this->page = Page::where('id', $pageIdentifier)->orWhere('slug', $pageIdentifier)->first();
            
            if (!$this->page) {
                // If ID/Slug passed but not found, abort or redirect.
                // Aborting 404 is cleaner than a zombie builder state.
                abort(404, 'Página não encontrada.');
            }

            $this->title = $this->page->title;
            $this->slug = $this->page->slug;
            $this->meta_title = $this->page->meta_title;
            $this->meta_description = $this->page->meta_description;
            $this->is_active = $this->page->is_active;
            // Ensure content is array (JSON decoding handled by Cast or Accessor if setup, otherwise manual)
            // The model has 'content' cast to array/json usually.
            $this->blocks = $this->page->content ?? [];
        }
    }

    public function addBlock($type)
    {
        $blockClass = $this->getBlockClass($type);
        if ($blockClass) {
            $block = new $blockClass();
            $this->blocks[] = $block->toArray();
        }
    }

    public function removeBlock($index)
    {
        unset($this->blocks[$index]);
        $this->blocks = array_values($this->blocks); // Reindex
    }

    public function updateBlockOrder($orderedIds)
    {
        // Simple reorder logic based on IDs if needed, 
        // or just rely on the frontend dragging implicitly updating the array via wire:model (if configured)
        // For now, let's assume we sort $this->blocks based on $orderedIds
        
        $newBlocks = [];
        foreach ($orderedIds as $id) {
             foreach ($this->blocks as $block) {
                 if ($block['id'] === $id) {
                     $newBlocks[] = $block;
                     break;
                 }
             }
        }
        $this->blocks = $newBlocks;
    }
    
    // Mapping helper
    protected function getBlockClass($type)
    {
        // Use the same mapping as BlockFactory or direct valid classes
        return match($type) {
            'text' => \App\Cms\Blocks\TextBlock::class,
            'hero' => \App\Cms\Blocks\HeroBlock::class,
            'faq' => \App\Cms\Blocks\FaqBlock::class,
            'contact' => \App\Cms\Blocks\ContactBlock::class,
            default => null,
        };
    }

    public function updatedTitle($value)
    {
        if (!$this->page) {
            $this->slug = Str::slug($value);
        }
    }

    public function save(UpdatePageContentAction $action)
    {
        $this->validate([
            'title' => 'required',
            'slug' => [
                'required',
                'unique:pages,slug,' . ($this->page->id ?? 'NULL'),
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'logout', 'register', 'password', 'api', 'loja', 'shop', 'cart', 'checkout'];
                    if (in_array(Str::slug($value), $reserved)) {
                        $fail('Este slug é reservado pelo sistema.');
                    }
                },
            ],
        ]);

        // 1. Save Page Properties
        $pageData = [
            'title' => $this->title,
            'slug' => $this->slug,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'is_active' => $this->is_active,
        ];

        if ($this->page) {
            $this->page->update($pageData);
        } else {
            $this->page = Page::create($pageData);
        }

        // 2. Delegate Block Processing to Action
        // The action handles validation/sanitization of blocks
        try {
            $action->execute($this->page, $this->blocks);
            session()->flash('success', 'Página salva com sucesso!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao processar blocos: ' . $e->getMessage());
        }

        return redirect()->route('admin.cms.pages.builder', ['page' => $this->page->id]);
    }

    public function render()
    {
        return view('livewire.cms.page-builder')->layout('layouts.admin');
    }
}
