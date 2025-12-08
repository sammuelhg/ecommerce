<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\ContactDTO;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendContactEmailAction
{
    public function execute(ContactDTO $dto): void
    {
        // Log for debugging/audit
        Log::info('Contact Form Submission', [
            'email' => $dto->email,
            'name' => $dto->name
        ]);

        // Send Email to Admin (configured in .env MAIL_FROM_ADDRESS or specific admin email)
        $adminEmail = config('mail.from.address');
        
        Log::info('Attempting to send Contact Email via SMTP', [
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'username' => config('mail.mailers.smtp.username'),
        ]);
        
        try {
            Mail::to($adminEmail)->send(new ContactFormMail($dto));
            Log::info('Contact Email SENT successfully to: ' . $adminEmail);
        } catch (\Exception $e) {
            Log::error('Contact Email FAILED to send: ' . $e->getMessage());
            throw $e; // Re-throw so Livewire catches it
        }
    }
}
