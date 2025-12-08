<?php

declare(strict_types=1);

namespace App\Mail;

use App\DTOs\HighlightsDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HighlightsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public HighlightsDTO $data
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Destaques para você',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.highlights',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
