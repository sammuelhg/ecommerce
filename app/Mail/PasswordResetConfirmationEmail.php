<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public ?string $newPassword;
    public string $loginUrl;
    public string $siteName;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, ?string $newPassword = null)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
        $this->loginUrl = route('login');
        $this->siteName = config('app.name');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Senha redefinida com sucesso no ' . $this->siteName . '!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
