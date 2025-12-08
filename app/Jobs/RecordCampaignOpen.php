<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\CampaignOpen;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class RecordCampaignOpen implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $campaignId,
        public int $subscriberId,
        public ?string $ipAddress,
        public ?string $userAgent
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Debounce logic: Check if the same subscriber opened the same campaign in the last minute
        $recentOpen = CampaignOpen::where('newsletter_campaign_id', $this->campaignId)
            ->where('newsletter_subscriber_id', $this->subscriberId)
            ->where('created_at', '>=', Carbon::now()->subMinute())
            ->exists();

        if ($recentOpen) {
            return;
        }

        CampaignOpen::create([
            'newsletter_campaign_id' => $this->campaignId,
            'newsletter_subscriber_id' => $this->subscriberId,
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
        ]);
    }
}
