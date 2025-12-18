<?php

declare(strict_types=1);

namespace App\Actions\Campaign;

use App\Domains\Marketing\Models\Campaign;
use App\Domains\Marketing\Models\Lead;
use App\Mail\CampaignMail;
use Illuminate\Support\Facades\Mail;

class SendCampaignEmailAction
{
    public function __construct(
        protected CompileEmailContentAction $compiler
    ) {}

    public function execute(Campaign $campaign, Lead $lead): void
    {
        // 1. Check if campaign is active (double check)
        // (Assuming active check is done before calling this, but safe to check)
        
        // 2. Compile Content
        $html = $this->compiler->execute($campaign, $lead);
        
        // 3. Get Subject (Replace tokens in subject too if needed)
        $subject = $campaign->sending_rules['subject'] ?? 'Novidades da LosFit';
        $subject = str_replace('{name}', explode(' ', $lead->name ?? '')[0], $subject);

        // 4. Send
        Mail::to($lead->email)->send(new CampaignMail($html, $subject));
    }
}
