<?php

namespace App\Livewire\Admin;

use App\Models\LinkItem;
use App\Models\StoreSetting;
use Livewire\Component;

class LinkItemIndex extends Component
{
    public $links;
    
    // Page settings
    public $pageTitle = '';
    public $pageSubtitle = '';
    
    // Form fields
    public $linkId = null;
    public $title = '';
    public $url = '';
    public $icon = '';
    public $color = 'white';
    public $is_active = true;
    
    public $showModal = false;
    public $editMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'url' => 'required|string|max:255',
        'icon' => 'nullable|string',
        'color' => 'required|string',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->pageTitle = StoreSetting::get('links_page_title', 'LosFit 1000');
        $this->pageSubtitle = StoreSetting::get('links_page_subtitle', 'Performance & Lifestyle');
        $this->loadLinks();
    }

    public function savePageSettings()
    {
        StoreSetting::set('links_page_title', $this->pageTitle);
        StoreSetting::set('links_page_subtitle', $this->pageSubtitle);
        session()->flash('success', 'Configurações salvas!');
    }

    public function loadLinks()
    {
        $this->links = LinkItem::ordered()->get();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->editMode = false;
    }

    public function openEditModal($id)
    {
        $link = LinkItem::findOrFail($id);
        $this->linkId = $link->id;
        $this->title = $link->title;
        $this->url = $link->url;
        $this->icon = $link->icon ?? '';
        $this->color = $link->color;
        $this->is_active = $link->is_active;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function setIcon($iconName)
    {
        $this->icon = '<i class="bi bi-' . $iconName . '"></i>';
    }

    public function clearIcon()
    {
        $this->icon = '';
    }

    public function setColor($colorKey)
    {
        $this->color = $colorKey;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'url' => $this->url,
            'icon' => $this->icon ?: null,
            'color' => $this->color,
            'is_active' => $this->is_active,
        ];

        if ($this->editMode) {
            $link = LinkItem::findOrFail($this->linkId);
            $link->update($data);
        } else {
            $data['order'] = LinkItem::max('order') + 1;
            LinkItem::create($data);
        }

        $this->closeModal();
        $this->loadLinks();
        session()->flash('success', 'Link salvo!');
    }

    public function delete($id)
    {
        LinkItem::findOrFail($id)->delete();
        $this->loadLinks();
        session()->flash('success', 'Link excluído!');
    }

    public function moveUp($id)
    {
        $link = LinkItem::findOrFail($id);
        $prev = LinkItem::where('order', '<', $link->order)->orderBy('order', 'desc')->first();
        if ($prev) {
            $tempOrder = $link->order;
            $link->update(['order' => $prev->order]);
            $prev->update(['order' => $tempOrder]);
        }
        $this->loadLinks();
    }

    public function moveDown($id)
    {
        $link = LinkItem::findOrFail($id);
        $next = LinkItem::where('order', '>', $link->order)->orderBy('order', 'asc')->first();
        if ($next) {
            $tempOrder = $link->order;
            $link->update(['order' => $next->order]);
            $next->update(['order' => $tempOrder]);
        }
        $this->loadLinks();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->linkId = null;
        $this->title = '';
        $this->url = '';
        $this->icon = '';
        $this->color = 'white';
        $this->is_active = true;
    }

    public function render()
    {
        return view('livewire.admin.link-item-index', [
            'colorOptions' => LinkItem::$colorOptions,
            'iconOptions' => LinkItem::$iconOptions,
        ]);
    }
}
