<?php

namespace App\Livewire\Admin;

use App\Models\EmailCard;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmailCardIndex extends Component
{
    use WithFileUploads;

    public $cards;
    
    // Form fields
    public $cardId = null;
    public $name = '';
    public $sender_name = '';
    public $sender_role = '';
    public $instagram = '';
    public $whatsapp = '';
    public $website = '';
    public $slogan = '';
    public $is_active = true;
    public $photo;
    public $existingPhoto = null;
    
    public $showModal = false;
    public $editMode = false;

    protected $rules = [
        'sender_name' => 'required|string|max:255',
        'sender_role' => 'nullable|string|max:255',
        'instagram' => 'nullable|string|max:255',
        'whatsapp' => 'nullable|string|max:255',
        'website' => 'nullable|string|max:255',
        'slogan' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'photo' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->loadCards();
    }

    public function loadCards()
    {
        $this->cards = EmailCard::orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $card = EmailCard::findOrFail($id);
        $this->cardId = $card->id;
        $this->name = $card->name;
        $this->sender_name = $card->sender_name;
        $this->sender_role = $card->sender_role;
        $this->instagram = $card->instagram;
        $this->whatsapp = $card->whatsapp;
        $this->website = $card->website;
        $this->slogan = $card->slogan;
        $this->is_active = $card->is_active;
        $this->existingPhoto = $card->photo;
        $this->photo = null;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->sender_name, // Use sender_name as internal name
            'sender_name' => $this->sender_name,
            'sender_role' => $this->sender_role,
            'instagram' => ltrim($this->instagram, '@'),
            'whatsapp' => preg_replace('/[^0-9]/', '', $this->whatsapp),
            'website' => $this->website,
            'slogan' => $this->slogan,
            'is_active' => $this->is_active,
        ];

        // Handle photo upload - save directly to public folder
        if ($this->photo) {
            $extension = $this->photo->getClientOriginalExtension() ?: 'jpg';
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $this->photo->storeAs('email-cards', $filename, 'public_uploads');
            $data['photo'] = 'email-cards/' . $filename;
        }

        if ($this->editMode) {
            $card = EmailCard::findOrFail($this->cardId);
            $card->update($data);
            session()->flash('success', 'Card atualizado com sucesso!');
        } else {
            EmailCard::create($data);
            session()->flash('success', 'Card criado com sucesso!');
        }

        $this->closeModal();
        $this->loadCards();
    }

    public function removePhoto()
    {
        if ($this->editMode && $this->cardId) {
            $card = EmailCard::findOrFail($this->cardId);
            if ($card->photo && file_exists(public_path($card->photo))) {
                unlink(public_path($card->photo));
            }
            $card->update(['photo' => null]);
            $this->existingPhoto = null;
        }
        $this->photo = null;
    }

    public function setAsDefault($id)
    {
        $card = EmailCard::findOrFail($id);
        $card->setAsDefault();
        $this->loadCards();
        session()->flash('success', 'Card definido como padrão!');
    }

    public function delete($id)
    {
        $card = EmailCard::findOrFail($id);
        if ($card->photo && file_exists(public_path($card->photo))) {
            unlink(public_path($card->photo));
        }
        $card->delete();
        $this->loadCards();
        session()->flash('success', 'Card excluído!');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->cardId = null;
        $this->name = '';
        $this->sender_name = '';
        $this->sender_role = '';
        $this->instagram = '';
        $this->whatsapp = '';
        $this->website = '';
        $this->slogan = '';
        $this->is_active = true;
        $this->photo = null;
        $this->existingPhoto = null;
    }

    public function render()
    {
        return view('livewire.admin.email-card-index');
    }
}
