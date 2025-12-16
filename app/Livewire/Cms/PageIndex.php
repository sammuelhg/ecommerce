<?php

namespace App\Livewire\Cms;

use Livewire\Component;

class PageIndex extends Component
{
    public function render()
    {
        return view('livewire.cms.page-index')->layout('layouts.admin');
    }
}
