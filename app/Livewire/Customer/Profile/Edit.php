<?php

namespace App\Livewire\Customer\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $taxvat;
    public $password = '';
    public $password_confirmation = '';
    public $avatar;
    public $currentAvatar;

    protected $rules = [
        'name'  => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:20',
        'taxvat'=> 'nullable|string|max:18',
        'avatar'=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'password' => 'nullable|min:8|confirmed',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->taxvat = $user->taxvat;
        $this->currentAvatar = $user->avatar_url;
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();

        $data = [
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'taxvat'=> $this->taxvat,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->avatar) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        $user->update($data);

        // Update current avatar preview
        $this->currentAvatar = $user->fresh()->avatar_url ?? $this->currentAvatar;

        $this->dispatch('toast', [
            'title' => 'Sucesso!',
            'text'  => 'Perfil atualizado com sucesso.',
            'icon'  => 'success'
        ]);

        $this->password = $this->password_confirmation = '';
    }

    public function render()
    {
        return view('livewire.customer.profile.edit')
            ->layout('layouts.shop');
    }
}
