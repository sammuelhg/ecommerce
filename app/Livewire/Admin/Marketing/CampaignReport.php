<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Marketing;

use App\Domains\Marketing\Models\CampaignOpen;
use App\Domains\Marketing\Models\NewsletterCampaign;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class CampaignReport extends Component
{
    use WithPagination;

    public NewsletterCampaign $campaign;

    public function mount(NewsletterCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function render()
    {
        $opens = CampaignOpen::where('newsletter_campaign_id', $this->campaign->id)
            ->with(['lead', 'lead.contact']) // Try to load lead and contact if applicable
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.admin.marketing.campaign-report', [
            'opens' => $opens
        ]);
    }
}
