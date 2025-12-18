<?php

namespace App\Livewire\Cms;

use App\Domains\Content\Models\CmsComponent;
use Livewire\Component;

class ComponentIndex extends Component
{
    public $components;

    public function mount()
    {
        $this->components = CmsComponent::all();
    }

    public function render()
    {
        return view('livewire.cms.component-index')->layout('layouts.admin');
    }
}
