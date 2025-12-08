<?php

declare(strict_types=1);

namespace App\Livewire\Shop;

use App\Actions\SendContactEmailAction;
use App\DTOs\ContactDTO;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ContactForm extends Component
{
    #[Validate('required|min:3')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:8')]
    public string $phone = '';

    #[Validate('required|min:10')]
    public string $message = '';

    public bool $success = false;
    public ?string $errorMessage = null;

    public function submit(SendContactEmailAction $action): void
    {
        $this->validate();
        $this->errorMessage = null;

        $dto = new ContactDTO(
            name: $this->name,
            phone: $this->phone,
            email: $this->email,
            message: $this->message
        );

        try {
            $action->execute($dto);
            $this->success = true;
            $this->reset(['name', 'email', 'phone', 'message']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Contact Form Error: ' . $e->getMessage());
            $this->errorMessage = 'Erro ao enviar: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.shop.contact-form');
    }
}
