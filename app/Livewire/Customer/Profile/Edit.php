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
    public $isGoogleUser = false;
    public $isFacebookUser = false;
    public $socialProvider = null;
    public $hasPassword = true;
    public $showPasswordModal = false;
    public $googleSuggestedName = null;

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
        
        // Always pre-fill name (either from DB or social suggestion)
        $this->name = $user->name;
        
        // Store suggestion if available for reference
        if ($user->google_id || $user->facebook_id) {
            $this->googleSuggestedName = $user->name;
        }
        
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->taxvat = $user->taxvat;
        $this->currentAvatar = $user->avatar_url;
        
        // Check if user has a password set
        $this->hasPassword = !empty($user->password);
        
        // Check social login
        if ($user->google_id) {
            $this->isGoogleUser = true;
            $this->socialProvider = 'Google';
        } elseif ($user->facebook_id) {
            $this->isFacebookUser = true;
            $this->socialProvider = 'Facebook';
        }
    }

    public function setPassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->update(['password' => Hash::make($this->password)]);
        
        $this->hasPassword = true;
        
        // Dispatch event to close modal via JS
        $this->dispatch('password-set');
        
        $this->dispatch('toast', [
            'title' => 'Sucesso!',
            'text'  => 'Senha definida com sucesso. Agora você pode fazer login com email e senha.',
            'icon'  => 'success'
        ]);
        
        // Reset password fields
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();
        
        // Use suggested name if user didn't enter one
        $finalName = !empty($this->name) ? $this->name : ($this->googleSuggestedName ?? $user->name);

        $data = [
            'name'  => $finalName,
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
