<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessNewsletterSequences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:process-sequences';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process newsletter sequences and send due emails';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting sequence processing...');

        // Get active enrollments
        $enrollments = \Illuminate\Support\Facades\DB::table('newsletter_campaign_subscriber')
            ->whereNull('completed_at')
            ->get();

        foreach ($enrollments as $enrollment) {
            $campaign = \App\Models\NewsletterCampaign::find($enrollment->newsletter_campaign_id);
            $subscriber = \App\Models\NewsletterSubscriber::find($enrollment->newsletter_subscriber_id);

            if (!$campaign || !$subscriber || !$subscriber->is_active) {
                // Determine if we should mark complete or delete? For now skip.
                continue;
            }

            // Determine Target Email
            $targetEmail = null;
            $shouldSend = false;

            if (!$enrollment->current_email_id) {
                // Logic: Fresh Enrollment. Get First Email.
                $targetEmail = $campaign->emails()->orderBy('sort_order')->first();
                if ($targetEmail) {
                    $delayHours = $targetEmail->delay_in_hours;
                    $readyAt = \Carbon\Carbon::parse($enrollment->started_at)->addHours($delayHours);
                    if (now()->greaterThanOrEqualTo($readyAt)) {
                        $shouldSend = true;
                    }
                } else {
                    // Campaign has no emails? Mark complete.
                    $this->markComplete($enrollment->id);
                    continue;
                }
            } else {
                // Logic: Has processed at least one email. Look for next.
                $currentEmail = \App\Models\NewsletterEmail::find($enrollment->current_email_id);
                if (!$currentEmail) {
                    // Current email deleted? Move next.
                    $targetEmail = $campaign->emails()->where('sort_order', '>', 0)->orderBy('sort_order')->first(); 
                } else {
                    $targetEmail = $campaign->emails()
                        ->where('sort_order', '>', $currentEmail->sort_order)
                        ->orderBy('sort_order')
                        ->first();
                }

                if ($targetEmail) {
                    $delayHours = $targetEmail->delay_in_hours;
                    // Relative to LAST SENT
                    $reference = $enrollment->last_email_sent_at ? \Carbon\Carbon::parse($enrollment->last_email_sent_at) : \Carbon\Carbon::parse($enrollment->started_at);
                    $readyAt = $reference->addHours($delayHours);
                    
                    if (now()->greaterThanOrEqualTo($readyAt)) {
                        $shouldSend = true;
                    }
                } else {
                    // No more emails. Mark complete.
                    $this->markComplete($enrollment->id);
                    continue;
                }
            }

            // Send
            if ($shouldSend && $targetEmail) {
                try {
                    \Illuminate\Support\Facades\Mail::to($subscriber->email)
                        ->send(new \App\Mail\CampaignMail($campaign, $subscriber, $targetEmail));
                    
                    // Update Pivot
                    \Illuminate\Support\Facades\DB::table('newsletter_campaign_subscriber')
                        ->where('id', $enrollment->id)
                        ->update([
                            'current_email_id' => $targetEmail->id,
                            'last_email_sent_at' => now(),
                        ]);
                    
                    $this->info("Sent Email [{$targetEmail->subject}] to {$subscriber->email}");
                } catch (\Exception $e) {
                    $this->error("Failed to send to {$subscriber->email}: " . $e->getMessage());
                }
            }
        }

        $this->info('Sequence processing completed.');
    }

    private function markComplete($enrollmentId)
    {
        \Illuminate\Support\Facades\DB::table('newsletter_campaign_subscriber')
            ->where('id', $enrollmentId)
            ->update(['completed_at' => now()]);
    }
}
