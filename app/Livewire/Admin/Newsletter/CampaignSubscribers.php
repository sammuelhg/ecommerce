<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Newsletter;

use App\Models\NewsletterCampaign;
use App\Models\NewsletterSubscriber;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Lazy]
class CampaignSubscribers extends Component
{
    use WithPagination;

    public NewsletterCampaign $campaign;
    public string $search = '';

    public function mount(NewsletterCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function removeSubscriber(int $subscriberId): void
    {
        // Detach instead of deleting the user
        $this->campaign->subscribers()->detach($subscriberId);
        $this->dispatch('show-toast', type: 'success', message: 'Inscrito removido da campanha.');
    }

    public function render()
    {
        $query = $this->campaign->subscribers()
            ->orderByPivot('created_at', 'desc');

        if ($this->search) {
            $query->where('email', 'like', '%' . $this->search . '%')
                  ->orWhere('name', 'like', '%' . $this->search . '%');
        }

        return view('livewire.admin.newsletter.campaign-subscribers', [
            'subscribers' => $query->paginate(20)
        ]);
    }
}
