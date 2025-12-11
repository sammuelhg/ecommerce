<?php


declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    /**
     * Create a new job instance.
     */
    public function __construct(
        public \App\Models\NewsletterEmail $email,
        public \App\Models\NewsletterSubscriber $subscriber
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Replace generic subject/body variables if needed
            // For now, simpler: pass campaign to Mailable
            
            \Illuminate\Support\Facades\Mail::to($this->subscriber->email)
                ->send(new \App\Mail\CampaignEmail($this->email, $this->subscriber));
            
            // Optional: Log success or update counters
            // \App\Models\CampaignOpen::create([...]) ? No, that's for opens.
            // Maybe Increment campaign sent_count if we add that column.

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send campaign {$this->campaign->id} to {$this->subscriber->email}: " . $e->getMessage());
            $this->fail($e);
        }
    }
}
