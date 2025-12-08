<?php

namespace App\Livewire\Admin\Newsletter;

use App\Models\NewsletterCampaign;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CampaignManager extends Component
{
    public $campaigns;
    public $subject;
    public $body;
    public $showModal = false;

    protected $rules = [
        'subject' => 'required|min:5',
        'body' => 'required|min:10',
    ];

    public function mount()
    {
        $this->loadCampaigns();
    }

    public function loadCampaigns()
    {
        $this->campaigns = NewsletterCampaign::orderBy('created_at', 'desc')->get();
    }

    public function save()
    {
        $this->validate();

        NewsletterCampaign::create([
            'subject' => $this->subject,
            'body' => $this->body,
            'status' => 'draft'
        ]);

        $this->reset(['subject', 'body']);
        $this->showModal = false;
        $this->loadCampaigns();
        session()->flash('message', 'Campanha criada com sucesso!');
    }

    public function send($id)
    {
        $campaign = NewsletterCampaign::find($id);
        
        if (!$campaign || $campaign->status === 'sent') {
            return;
        }

        // Determine receivers
        $subscribers = NewsletterSubscriber::where('is_active', true)->get();

        foreach ($subscribers as $subscriber) {
            // In a real app, we should use Queues
            try {
                // We'll create a generic CampaignMail mailable
                Mail::to($subscriber->email)->send(new \App\Mail\CampaignMail($campaign));
            } catch (\Exception $e) {
                // logging
            }
        }

        $campaign->update([
            'status' => 'sent',
            'sent_at' => now()
        ]);

        $this->loadCampaigns();
        session()->flash('message', 'Campanha enviada para ' . $subscribers->count() . ' assinantes.');
    }

    public function render()
    {
        return view('livewire.admin.newsletter.campaign-manager')
            ->extends('layouts.admin')
            ->section('content');
    }
}
