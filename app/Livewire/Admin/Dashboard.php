<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Lead;
use App\Models\Form;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public int $totalLeads = 0;
    public int $totalForms = 0;
    public array $recentLeads = [];

    public function mount(): void
    {
        $this->refreshStats();
    }

    public function refreshStats(): void
    {
        $this->totalLeads = Lead::count();
        $this->totalForms = Form::where('is_active', true)->count();
        
        $this->recentLeads = Lead::with('form')
            ->latest()
            ->take(5)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
