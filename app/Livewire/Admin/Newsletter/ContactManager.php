<?php

namespace App\Livewire\Admin\Newsletter;

use Livewire\Component;

class ContactManager extends Component
{
    use \Livewire\WithPagination;

    public $search = '';

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
            'contacts' => $contacts
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
