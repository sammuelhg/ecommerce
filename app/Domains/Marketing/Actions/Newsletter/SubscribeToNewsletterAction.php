<?php

declare(strict_types=1);

namespace App\Actions\Newsletter;

use App\Domains\Marketing\Models\Lead;
use App\Mail\WelcomeNewsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SubscribeToNewsletterAction
{
    /**
     * Subscribe an email to the newsletter (Creates a Lead).
     * 
     * @param string $email The subscriber's email.
     * @param string $source The source of subscription (e.g., 'footer', 'grid').
     * @return Lead
     */
    public function execute(string $email, string $source, array $utms = [], ?int $campaignId = null): Lead
    {
        // 1. Create or Update Lead
        // We use 'active' status for subscribed leads.
        // We append 'newsletter' to source if it's not already indicated? 
        // Or just trust the passed source. If coming from footer, source='newsletter_footer'.
        
        $data = [
            'name' => explode('@', $email)[0], // Simple fallback for name
            'source' => $source, 
            'status' => 'active', // Enum/String 'active'
            'utm_source' => $utms['utm_source'] ?? null,
            'utm_medium' => $utms['utm_medium'] ?? null,
            'utm_campaign' => $utms['utm_campaign'] ?? null,
            'utm_content' => $utms['utm_content'] ?? null,
        ];

        // If lead exists, we update status to active if they were unsubscribed?
        // Or we just update UTMs? Let's safeguard status.
        $lead = Lead::where('email', $email)->first();
        
        if ($lead) {
            $lead->update(array_merge($data, ['status' => 'active']));
        } else {
            $lead = Lead::create(array_merge(['email' => $email], $data));
        }

        // 1a. Enroll in Campaign if provided
        if ($campaignId) {
            $campaign = \App\Domains\Marketing\Models\NewsletterCampaign::find($campaignId);
            if ($campaign && $campaign->is_active) {
                // Check if already enrolled
                if (!$lead->campaigns()->where('newsletter_campaign_id', $campaignId)->exists()) {
                     // Get first email
                     $firstEmail = $campaign->emails()->orderBy('sort_order')->first();
                     
                     $lead->campaigns()->attach($campaignId, [
                         'started_at' => now(),
                         'current_email_id' => $firstEmail?->id,
                         'last_email_sent_at' => $firstEmail ? now() : null,
                     ]);

                     // Send Immediate First Email (Bypassing Scheduler)
                     if ($firstEmail) {
                         try {
                             // Assuming we update Mail as well or it uses dynamic properties.
                             Mail::to($email)->send(new \App\Mail\CampaignEmail($firstEmail, $lead));
                             Log::info("Campaign First Email Sent: {$email} (Campaign: {$campaignId})");
                         } catch (\Exception $e) {
                             Log::error("Campaign Email Failed: " . $e->getMessage());
                         }
                     }
                }
            }
        }

        // 2. Send Welcome Email
        if (!$campaignId) {
            try {
                // Ensure WelcomeNewsletter accepts Lead
                Mail::to($email)->send(new WelcomeNewsletter($lead));
                Log::info("Newsletter Welcome Sent: {$email} (Source: {$source})");
            } catch (\Exception $e) {
                Log::error("Newsletter Email Failed for {$email}: " . $e->getMessage());
            }
        }

        return $lead;
    }
}
