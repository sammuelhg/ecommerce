<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendCampaignJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public \App\Models\NewsletterCampaign $campaign
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1. Mark campaign as sending (if not already)
        if ($this->campaign->status !== 'sending') {
            $this->campaign->update(['status' => 'sending']);
        }

        // 2. Fetch Active Subscribers
        // PREPARE: Find the first email to send (for now assuming 1 email per campaign for bulk send)
        // Or should we send ALL emails? Usually drip is scheduled.
        // Let's assume we send the FIRST email of the sequence now.
        $email = $this->campaign->emails()->orderBy('sort_order')->first();
        
        if (!$email) {
            \Illuminate\Support\Facades\Log::warning("Campaign {$this->campaign->id} has no emails to send.");
            $this->campaign->update(['status' => 'draft']); // Revert
            return;
        }

        \App\Models\NewsletterSubscriber::where('is_active', true)
            ->chunk(100, function ($subscribers) use ($email) {
                foreach ($subscribers as $subscriber) {
                    // Dispatch individual email job
                    \App\Jobs\SendEmailJob::dispatch($email, $subscriber);
                }
            });

        // 3. Mark as sent? 
        // Problem: Since jobs are async, we can't mark as 'sent' immediately here if we want strict status.
        // But for MVP, we can mark as 'sent' (meaning "Process Completed") or 'processing'.
        // Let's mark as 'sent' for now, or maybe 'processed'.
        $this->campaign->update(['status' => 'sent', 'sent_at' => now()]);
    }
}
