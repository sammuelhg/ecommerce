<?php

namespace App\Livewire;

use Livewire\Component;

class NewsletterFooter extends Component
{
    public $email;
    public $success = false;

    protected $rules = [
        'email' => 'required|email|unique:newsletter_subscribers,email',
    ];

    public function subscribe()
    {
        $this->validate();

        \App\Models\NewsletterSubscriber::create([
            'email' => $this->email,
            'source' => 'footer'
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($this->email)->send(new \App\Mail\WelcomeNewsletter());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Newsletter email failed: ' . $e->getMessage());
        }

        $this->success = true;
        $this->email = '';
        
        session()->flash('message', 'Inscrição realizada! Cupom: WELCOME15');
    }

    public function render()
    {
        return view('livewire.newsletter-footer');
    }
}
