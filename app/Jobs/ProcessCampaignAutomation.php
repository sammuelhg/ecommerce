<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Actions\Campaign\SendCampaignEmailAction;
use App\Domains\Marketing\Models\Campaign;
use App\Domains\Marketing\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCampaignAutomation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Lead $lead,
        public Campaign $campaign
    ) {}

    public function handle(SendCampaignEmailAction $sendAction): void
    {
        // 1. Check if campaign is still active
        if (!$this->campaign->refresh()->is_active) {
            return;
        }

        // 2. Check Sending Rules (Future: Delay, etc.)
        // For MVP: Send immediately.
        
        try {
            Log::info("Processing Campaign Automation: Campaign {$this->campaign->id} -> Lead {$this->lead->id}");
            
            $sendAction->execute($this->campaign, $this->lead);
            
            Log::info("Campaign Automation Sent Successfully");

        } catch (\Throwable $e) {
            Log::error("Failed to send campaign automation: " . $e->getMessage());
            // Retry logic could go here
            $this->fail($e);
        }
    }
}
