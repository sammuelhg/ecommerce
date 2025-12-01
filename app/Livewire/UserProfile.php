<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $birth_date;
    
    public $editing = false;

    protected $rules = [
        'name' => 'required|min:3',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'birth_date' => 'nullable|date|before:today',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->birth_date = $user->birth_date ? $user->birth_date->format('Y-m-d') : null;
    }

    public function toggleEdit()
    {
        $this->editing = !$this->editing;
        if (!$this->editing) {
            // Reset to current values if canceling
            $this->mount();
        }
    }

    public function save()
    {
        $this->validate();

        Auth::user()->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'birth_date' => $this->birth_date,
        ]);

        $this->editing = false;
        session()->flash('message', 'Perfil atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.user-profile')->layout('layouts.app');
    }
}
