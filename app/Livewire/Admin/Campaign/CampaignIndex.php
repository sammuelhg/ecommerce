<?php

namespace App\Livewire\Admin\Campaign;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Marketing\Models\Campaign;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class CampaignIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $campaign = Campaign::find($id);
        if ($campaign) {
            $campaign->delete();
            session()->flash('success', 'Campanha excluída com sucesso.');
        }
    }

    public function render()
    {
        $campaigns = Campaign::query()
            ->with(['signCard', 'emails']) // Eager load
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.campaign.campaign-index', [
            'campaigns' => $campaigns
        ]);
    }
}
