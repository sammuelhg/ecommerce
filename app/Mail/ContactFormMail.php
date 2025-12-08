<?php

declare(strict_types=1);

namespace App\Mail;

use App\DTOs\ContactDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactDTO $data
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nova mensagem de ' . $this->data->name . ' - Fale Conosco',
            replyTo: [$this->data->email]
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: '
                <h1>Nova Mensagem do Site</h1>
                <p><strong>Nome:</strong> ' . e($this->data->name) . '</p>
                <p><strong>Email:</strong> ' . e($this->data->email) . '</p>
                <p><strong>Telefone:</strong> ' . e($this->data->phone) . '</p>
                <hr>
                <p><strong>Mensagem:</strong></p>
                <p>' . nl2br(e($this->data->message)) . '</p>
            '
        );
    }
}
