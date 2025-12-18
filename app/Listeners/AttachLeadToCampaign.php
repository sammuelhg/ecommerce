<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\LeadCaptured;
use App\Jobs\ProcessCampaignAutomation;
use App\Domains\Marketing\Models\Campaign;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttachLeadToCampaign implements ShouldQueue
{
    public function handle(LeadCaptured $event): void
    {
        $form = $event->form;
        $lead = $event->lead;

        // 1. Check if form has a campaign (The new strategy ID or Legacy Newsletter ID)
        if (!$form->campaign_id) {
            return;
        }

        $campaign = Campaign::find($form->campaign_id);
        
        // BRIDGE: Support for Legacy Newsletter Campaigns
        if (!$campaign) {
            $newsletterCampaign = \App\Domains\Marketing\Models\NewsletterCampaign::find($form->campaign_id);
            if ($newsletterCampaign && $newsletterCampaign->is_active) {
                 // Send the first email of the sequence immediately
                 $firstEmail = $newsletterCampaign->emails()->orderBy('step_order')->first();
                 
                 if ($firstEmail) {
                     $subject = $firstEmail->subject;
                     $body = $firstEmail->body;

                     // Basic Token Replacement
                     $firstName = explode(' ', $lead->name ?? '')[0];
                     $subject = str_replace('{name}', $firstName, $subject ?? '');
                     $body = str_replace('{name}', $firstName, $body ?? '');

                     \Illuminate\Support\Facades\Mail::to($lead->email)->send(new \App\Mail\CampaignMail($body, $subject));
                     
                     // Optional: Track in pivot if needed, but for now just sending is enough for the user request
                 }
                 return;
            }
        }
        
        if (!$campaign || !$campaign->is_active) {
            return;
        }

        // 2. Attach Lead to Campaign (if not already attached)
        $lead->campaign_id = $campaign->id;
        $lead->save();

        // 3. Dispatch Automation Job
        ProcessCampaignAutomation::dispatch($lead, $campaign);
    }
}
