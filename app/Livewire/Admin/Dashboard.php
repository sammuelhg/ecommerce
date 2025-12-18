<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Domains\Marketing\Models\Lead;
use App\Domains\Marketing\Models\Form;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
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
        try {
            $this->totalLeads = \App\Domains\Marketing\Models\Lead::count();
            $this->totalForms = \App\Domains\Marketing\Models\Form::where('is_active', true)->count();
            
            $this->recentLeads = \App\Domains\Marketing\Models\Lead::with('form')
                ->latest()
                ->take(5)
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            // Fallback for missing tables during migration/deploy
            $this->totalLeads = 0;
            $this->totalForms = 0;
            $this->recentLeads = [];
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
