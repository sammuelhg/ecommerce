<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\ContactDTO;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendContactEmailAction
{
    public function execute(ContactDTO $dto): void
    {
        // 1. Save Contact to Database
        $contact = \App\Models\Contact::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'message' => $dto->message,
            'is_read' => false,
        ]);

        Log::info('Contact Saved', ['id' => $contact->id]);

        // 2. Send Email to Admin (configured in .env MAIL_FROM_ADDRESS or specific admin email)
        $adminEmail = config('mail.from.address');
        
        try {
            Mail::to($adminEmail)->send(new ContactFormMail($dto));
            Log::info('Contact Email SENT successfully to: ' . $adminEmail);
        } catch (\Exception $e) {
            Log::error('Contact Email FAILED to send: ' . $e->getMessage());
            // We continue execution even if admin email fails, to try to send auto-response.
        }

        // 3. Auto-Response Campaign Logic
        $autoCampaignId = \App\Models\StoreSetting::get('contact_auto_response_campaign_id');
        
        if ($autoCampaignId) {
            $campaign = \App\Models\NewsletterCampaign::find($autoCampaignId);
            
            if ($campaign) {
                // Find or Create Subscriber
                // We use updateOrCreate to ensure name is updated if subscriber already exists
                $subscriber = \App\Models\NewsletterSubscriber::updateOrCreate(
                    ['email' => $dto->email],
                    [
                        'name' => $dto->name,
                        'is_active' => true, 
                        'source' => 'contact_form'
                    ]
                );

                // Dispatch Campaign Email
                // Using SendEmailJob directly
                // FORCE SYNCHRONOUS dispatch to ensure immediate delivery even if queue is not running
                
                $emailStep = $campaign->emails()->orderBy('sort_order')->first();

                if ($emailStep) {
                    \App\Jobs\SendEmailJob::dispatchSync($emailStep, $subscriber);
                    Log::info('Auto-Response Campaign Dispatched (Sync)', ['campaign_id' => $campaign->id, 'email_id' => $emailStep->id, 'subscriber_id' => $subscriber->id]);
                } else {
                    Log::warning('Auto-Response Campaign has no emails', ['campaign_id' => $campaign->id]);
                }
            }
        }
    }
}
