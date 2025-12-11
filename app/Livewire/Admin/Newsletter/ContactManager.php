<?php

namespace App\Livewire\Admin\Newsletter;

use Livewire\Component;

class ContactManager extends Component
{
    use \Livewire\WithPagination;

    public $search = '';
    public $autoResponseCampaignId;

    public function mount()
    {
        $this->autoResponseCampaignId = \App\Models\StoreSetting::get('contact_auto_response_campaign_id');
    }

    public function updatedAutoResponseCampaignId($value)
    {
        \App\Models\StoreSetting::set('contact_auto_response_campaign_id', $value);
        $this->dispatch('alert', type: 'success', message: 'Campanha de resposta automática atualizada.');
    }

    public function getCampaignsProperty()
    {
        return \App\Models\NewsletterCampaign::orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        $contacts = \App\Models\Contact::query()
            ->when($this->search, function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('message', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.admin.newsletter.contact-manager', [
            'contacts' => $contacts,
            'campaigns' => $this->campaigns
        ])
        ->layout('layouts.admin')
        ->title('Gerenciar Contatos do Site');
    }

    public function markAsRead($id)
    {
        $contact = \App\Models\Contact::findOrFail($id);
        $contact->update(['is_read' => true]);
    }

    public function delete($id)
    {
        \App\Models\Contact::findOrFail($id)->delete();
    }
}
