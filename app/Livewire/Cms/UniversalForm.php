<?php

namespace App\Livewire\Cms;

use Livewire\Component;
use App\Models\Form;
use App\Models\Lead;
use App\Enums\LeadStatus;
use App\DTOs\LeadData;
use App\Actions\Leads\CreateLeadAction;
use Illuminate\Support\Facades\Request;

// use Illuminate\Support\Facades\Mail;
// use App\Models\NewsletterCampaign;
// use App\Models\NewsletterEmail;
// use App\Mail\CampaignMail;

class UniversalForm extends Component
{
    public $slug;
    public $form;
    
    // Form Fields
    public $email;
    public $name;
    public $phone;
    
    public $success = false;
    public $headless = false;

    public $settingsOverride = [];

    public function mount($slug = null, $formId = null, $settings = [])
    {
        $this->slug = $slug;
        
        if ($formId) {
             $this->form = Form::where('id', $formId)->where('is_active', true)->first();
             // If we found the form by ID, we can set the slug for consistency if needed, though not strictly required
             if ($this->form && !$this->slug) {
                 $this->slug = $this->form->slug;
             }
        } elseif ($slug) {
            $this->form = Form::where('slug', $slug)->where('is_active', true)->first();
        }

        if ($this->form && !empty($settings)) {
            $this->settingsOverride = $settings;
            // Merge overrides into form settings momentarily for this request
            $currentSettings = $this->form->settings ?? [];
            $this->form->settings = array_merge($currentSettings, $settings);
        }
    }

    protected function rules() 
    {
        return [
            'email' => 'required|email',
            'name' => 'nullable|string',
            'phone' => 'nullable|string',
        ];
    }

    public function submit(CreateLeadAction $createLeadAction)
    {
        if (!$this->form) {
            return;
        }

        $this->validate();

        $dto = new LeadData(
            email: $this->email,
            name: $this->name,
            phone: $this->phone,
            source: $this->slug, // Source = Form Slug
            status: LeadStatus::NEW,
            utm_source: session('utm_source'),
            utm_medium: session('utm_medium'),
            utm_campaign: session('utm_campaign'),
            utm_content: session('utm_content'),
            meta: [
                'form_id' => $this->form->id,
                'form_title' => $this->form->title
            ]
        );

        $lead = $createLeadAction->execute($dto);

        // Automation: Dispatch Event for Campaign Processing (New Architecture)
        \App\Events\LeadCaptured::dispatch($lead, $this->form);

        // [Legacy] logic removed.
        // The AttachLeadToCampaign listener will handle:
        // 1. Linking lead to campaign
        // 2. Dispatching ProcessCampaignAutomation job

        $this->success = true;
        
        // Reset fields
        $this->reset(['email', 'name', 'phone']);
    }

    public function render()
    {
        // Ensure overrides are applied on every render (hydration validation)
        if ($this->form && !empty($this->settingsOverride)) {
            $currentSettings = $this->form->settings ?? [];
            $this->form->settings = array_merge($currentSettings, $this->settingsOverride);
        }

        return view('livewire.cms.universal-form');
    }
}
