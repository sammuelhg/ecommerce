<?php

declare(strict_types=1);

namespace App\Livewire\Admin\SignCard;

use App\Models\SignCard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class SignCardManager extends Component
{
    use WithFileUploads;

    public $cards;
    public $isEditing = false;
    public $cardId;

    // Form Fields
    public $name;
    public $role;
    public $signature_text;
    public $instagram; // NEW
    public $whatsapp;  // NEW
    public $website;   // NEW
    public $slogan;    // NEW
    public $avatar; 
    public $existingAvatarUrl; 

    protected $rules = [
        'name' => 'required|string|min:3',
        'role' => 'required|string|min:3',
        'signature_text' => 'nullable|string|max:100', // Keep as backup or specific msg
        'avatar' => 'nullable|image|max:1024',
        'instagram' => 'nullable|string|max:100',
        'whatsapp' => 'nullable|string|max:50',
        'website' => 'nullable|string|max:100',
        'slogan' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->cards = SignCard::latest()->get();
    }

    public function create()
    {
        $this->reset(['cardId', 'name', 'role', 'signature_text', 'avatar', 'existingAvatarUrl', 'instagram', 'whatsapp', 'website', 'slogan']);
        $this->isEditing = true;
    }

    public function edit($id)
    {
        $card = SignCard::findOrFail($id);
        $this->cardId = $card->id;
        $this->name = $card->name;
        $this->role = $card->role;
        $this->signature_text = $card->signature_text;
        // New Fields
        $this->instagram = $card->instagram;
        $this->whatsapp = $card->whatsapp;
        $this->website = $card->website;
        $this->slogan = $card->slogan;

        $this->existingAvatarUrl = $card->avatar_url;
        
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'role' => $this->role,
            'signature_text' => $this->signature_text,
            'instagram' => $this->instagram,
            'whatsapp' => $this->whatsapp,
            'website' => $this->website,
            'slogan' => $this->slogan,
        ];

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $data['avatar_url'] = '/storage/' . $path;
        }

        if ($this->cardId) {
            $card = SignCard::find($this->cardId);
            $card->update($data);
            session()->flash('success', 'Cartão de Assinatura atualizado!');
        } else {
            $data['user_id'] = auth()->id() ?? 1;
            SignCard::create($data);
            session()->flash('success', 'Cartão de Assinatura criado!');
        }

        $this->isEditing = false;
        $this->loadData();
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->reset(['avatar']);
    }

    public function delete($id)
    {
        SignCard::destroy($id);
        $this->loadData();
        session()->flash('success', 'Cartão removido.');
    }

    public function render()
    {
        return view('livewire.admin.sign-card.sign-card-manager');
    }
}
