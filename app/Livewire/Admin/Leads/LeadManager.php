<?php

namespace App\Livewire\Admin\Leads;

use App\Models\Lead;
use Livewire\Component;
use Livewire\WithPagination;

class LeadManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = 'all'; // all, active, banned
    public string $sourceFilter = '';

    // Reset pagination when searching
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSourceFilter(): void
    {
        $this->resetPage();
    }

    public function toggleStatus(int $id): void
    {
        $lead = Lead::findOrFail($id);
        
        // Toggle Logic: Active <-> Banned
        if ($lead->status === 'banned') {
            $lead->status = 'active'; // Or whatever enum value you use
            $msg = 'Lead ativado novamente.';
        } else {
            $lead->status = 'banned';
            $msg = 'Lead banido.';
        }
        
        $lead->save();
        
        $this->dispatch('show-toast', type: 'success', message: $msg);
    }

    public function delete(int $id): void
    {
        Lead::destroy($id);
        $this->dispatch('show-toast', type: 'success', message: 'Lead removido permanentemente.');
    }

    public function render()
    {
        $query = Lead::query()
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('email', 'like', '%' . $this->search . '%')
                  ->orWhere('name', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === 'active') {
            $query->where('status', 'active'); // Assuming 'active' is the string value
        } elseif ($this->filter === 'banned') {
            $query->where('status', 'banned');
        }

        if ($this->sourceFilter) {
            $query->where('source', $this->sourceFilter);
        }

        // Get unique sources
        $sources = Lead::select('source')->distinct()->pluck('source');

        return view('livewire.admin.leads.lead-manager', [
            'leads' => $query->paginate(20),
            'sources' => $sources
        ])->layout('layouts.admin');
    }
}
