<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CampaignEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public \App\Models\NewsletterEmail $email,
        public \App\Models\NewsletterSubscriber $subscriber
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $prefix = \App\Models\StoreSetting::get('email_subject_prefix', '[LosFit]');
        // Use Email subject, fallback to Campaign subject
        $subject = $this->email->subject ?? $this->email->campaign->subject ?? 'Novidades LosFit';
        
        return new Envelope(
            subject: $prefix . ' ' . $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // 1. Process Body Images (Relative -> Absolute)
        $body = $this->email->body ?? '';
        $appUrl = config('app.url');
        
        // Regex to find src="/storage..." and prepend App URL
        // Doesn't touch http/https urls
        $body = preg_replace('/src="\/storage/i', 'src="' . $appUrl . '/storage', $body);
        
        // 2. Parse Variables (Manual Blade-like interpolation)
        // Replaces {{ $user->name }} or {{$user->name}} with subscriber name
        $name = $this->subscriber->name ?? 'Cliente';
        $body = preg_replace('/\{\{\s*\$user->name\s*\}\}/', $name, $body);
        $body = preg_replace('/\{\{\s*\$user->email\s*\}\}/', $this->subscriber->email, $body);
        
        // 3. Fetch Products
        $products = $this->email->products; // Relationship
        
        // 3. Fetch Card (Email Override -> Campaign -> Default)
        $card = $this->email->campaign->emailCard; // Relationship

        return new Content(
            view: 'emails.newsletter.campaign',
            with: [
                'content' => $body,
                'trackingUrl' => route('tracking.open', ['campaign' => $this->email->campaign->id, 'lead' => $this->subscriber->id], true),
                'overrideProducts' => $products->count() > 0 ? $products : null,
                'overrideCard' => $card,
                // Pass subscriber for unsubscribe link
                'subscriber' => $this->subscriber,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
