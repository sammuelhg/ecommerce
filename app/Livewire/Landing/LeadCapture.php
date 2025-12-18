<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use App\Actions\Leads\CreateLeadAction;
use App\DTOs\LeadData;
use App\Enums\LeadStatus;
use App\Domains\Marketing\Services\UtmExtractorService;
use Illuminate\Support\Facades\Request;

class LeadCapture extends Component
{
    public $email = '';
    public $name = '';
    public $success = false;

    protected $rules = [
        'email' => 'required|email',
        'name' => 'nullable|string|max:255',
    ];

    public function submit(CreateLeadAction $createLeadAction, UtmExtractorService $utmExtractor)
    {
        $this->validate();

        // Capture UTMs from session or request
        $utmSource = session('utm_source');
        $utmMedium = session('utm_medium');
        $utmCampaign = session('utm_campaign');
        $utmContent = session('utm_content');

        $dto = new LeadData(
            email: $this->email,
            name: $this->name,
            phone: null,
            source: 'landing_history', // Specific source for this form
            status: LeadStatus::NEW,
            utm_source: $utmSource,
            utm_medium: $utmMedium,
            utm_campaign: $utmCampaign,
            utm_content: $utmContent,
            meta: ['form' => 'vip_club_history']
        );

        $createLeadAction->execute($dto);

        $this->success = true;
        $this->reset(['email', 'name']);
    }

    public function render()
    {
        return view('livewire.landing.lead-capture');
    }
}
