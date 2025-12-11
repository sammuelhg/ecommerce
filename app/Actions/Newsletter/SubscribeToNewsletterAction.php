<?php

declare(strict_types=1);

namespace App\Actions\Newsletter;

use App\Models\NewsletterSubscriber;
use App\Mail\WelcomeNewsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SubscribeToNewsletterAction
{
    /**
     * Subscribe an email to the newsletter.
     * 
     * @param string $email The subscriber's email.
     * @param string $source The source of subscription (e.g., 'footer', 'grid').
     * @return NewsletterSubscriber
     */
    public function execute(string $email, string $source, array $utms = [], ?int $campaignId = null): NewsletterSubscriber
    {
        // 1. Create or Update Subscriber (Persist Source & UTMs)
        $data = [
            'source' => $source, 
            'is_active' => true,
            'utm_source' => $utms['utm_source'] ?? null,
            'utm_medium' => $utms['utm_medium'] ?? null,
            'utm_campaign' => $utms['utm_campaign'] ?? null,
            'utm_content' => $utms['utm_content'] ?? null,
        ];

        $subscriber = NewsletterSubscriber::updateOrCreate(
            ['email' => $email],
            $data
        );

        // 1a. Enroll in Campaign if provided
        if ($campaignId) {
            $campaign = \App\Models\NewsletterCampaign::find($campaignId);
            if ($campaign && $campaign->is_active) {
                // Check if already enrolled to avoid duplicates (though constraint handles it, better safe)
                if (!$subscriber->campaigns()->where('newsletter_campaign_id', $campaignId)->exists()) {
                     // Get first email
                     $firstEmail = $campaign->emails()->orderBy('sort_order')->first();
                     
                     $subscriber->campaigns()->attach($campaignId, [
                         'started_at' => now(),
                         'current_email_id' => $firstEmail?->id,
                         'last_email_sent_at' => $firstEmail ? now() : null,
                     ]);

                     // Send Immediate First Email (Bypassing Scheduler)
                     if ($firstEmail) {
                         try {
                             Mail::to($email)->send(new \App\Mail\CampaignMail($campaign, $subscriber, $firstEmail));
                             Log::info("Campaign First Email Sent: {$email} (Campaign: {$campaignId})");
                         } catch (\Exception $e) {
                             Log::error("Campaign Email Failed: " . $e->getMessage());
                         }
                     }
                }
            }
        }

        // 2. Send Welcome Email (Synchronous for now, can be queued later)
        // Only send generic welcome if NOT part of a campaign? 
        // Or send both? User probably wants the Campaign to BE the welcome.
        // If enrolled in campaign, maybe skip generic welcome?
        // Let's keep generic for now unless we decide otherwise. 
        // Actually, if it's a "Welcome Sequence", we definitely don't want the generic one too.
        
        if (!$campaignId) {
            try {
                Mail::to($email)->send(new WelcomeNewsletter($subscriber));
                Log::info("Newsletter Welcome Sent: {$email} (Source: {$source})");
            } catch (\Exception $e) {
                Log::error("Newsletter Email Failed for {$email}: " . $e->getMessage());
            }
        }

        return $subscriber;
    }
}
