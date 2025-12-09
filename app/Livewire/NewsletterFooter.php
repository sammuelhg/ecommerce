<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

class NewsletterFooter extends Component
{
    public $email;
    public $success = false;
    public ?int $campaignId = null;

    protected $rules = [
        'email' => 'required|email|unique:newsletter_subscribers,email',
    ];

    public function mount()
    {
        // Optional: Same logic as Grid, or maybe Footer is always generic?
        // User said "formulário... do grid ou do footer... deve ter um id".
        // So let's try to attach it to the Featured Campaign if one exists.
        $campaign = \App\Models\NewsletterCampaign::where('status', \App\Enums\CampaignStatus::SENT) 
            ->whereNotNull('promo_image_url')
            ->latest()
            ->first();
            
        if ($campaign) {
            $this->campaignId = $campaign->id;
        }
    }

    public function subscribe(\App\Actions\SubscribeToNewsletterAction $action)
    {
        $this->validate();

        $action->execute($this->email, 'footer', [], $this->campaignId);

        $this->success = true;
        $this->email = '';
        
        session()->flash('message', 'Inscrição realizada! Cupom: WELCOME15');
    }

    public function render()
    {
        return view('livewire.newsletter-footer');
    }
}
