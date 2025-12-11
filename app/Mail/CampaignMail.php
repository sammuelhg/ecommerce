<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;
    public $subscriber;
    public $emailStep;

    /**
     * Create a new message instance.
     */
    public function __construct(\App\Models\NewsletterCampaign $campaign, $subscriber, $emailStep)
    {
        $this->campaign = $campaign;
        $this->subscriber = $subscriber;
        $this->emailStep = $emailStep;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailStep->subject ?? $this->campaign->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $trackingUrl = route('tracking.open', [
            'campaign' => $this->campaign->id, 
            'lead' => $this->subscriber->id,
            'email_id' => $this->emailStep->id ?? null // Handle potential null emailStep id if strictly required by route
        ]);

        // Process placeholder replacements
        // Support {{ name }} and {{ $user->name }} commonly used by users
        $body = str_replace(
            ['{{ name }}', '{{ $user->name }}', '{{$user->name}}'], 
            $this->subscriber->name ?? 'Cliente', 
            $this->emailStep->body
        );

        return new Content(
            markdown: 'emails.newsletter.campaign',
            with: [
                'content' => $body,
                'trackingUrl' => $trackingUrl,
            ],
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
