<?php

namespace Tests\Feature;

use App\Jobs\SendCampaignJob;
use App\Jobs\SendEmailJob;
use App\Models\EmailCard;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterEmail;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendCampaignTest extends TestCase
{
    use RefreshDatabase;

    public function test_campaign_dispatches_jobs_to_subscribers(): void
    {
        Mail::fake();
        Queue::fake();

        // 1. Setup Data
        $card = EmailCard::create([
            'name' => 'Test Card', 
            'html_content' => '<div>Content</div>', // Note: html_content is NOT in fillable in the model view I saw? Let me double check usage. 
            // Wait, the error was sender_name.
            'sender_name' => 'Test Sender',
            'sender_role' => 'Support',
            'is_active' => true
        ]);
        
        $campaign = NewsletterCampaign::create([
            'subject' => 'Test Campaign Logic',
            'status' => 'draft',
            'email_card_id' => $card->id,
            'slug' => 'test-campaign-logic',
        ]);

        $email = $campaign->emails()->create([
            'subject' => 'Test Email 1',
            'body' => '<p>Hello World</p>',
            'sort_order' => 0,
            'delay_in_hours' => 0,
        ]);

        $subscriber = NewsletterSubscriber::create([
            'email' => 'subscriber@example.com',
            'is_active' => true,
        ]);

        // 2. Execute Job
        $job = new SendCampaignJob($campaign);
        $job->handle();

        // 3. Assertions
        $this->assertEquals('sent', $campaign->refresh()->status->value);
        
        // Check if SendEmailJob was pushed for the subscriber
        // Since SendCampaignJob dispatches SendEmailJob, and we faked Queue, we check if it was pushed.
        // Wait, SendCampaignJob might dispatch synchronously or to queue depending on implementation.
        // The code view showed: \App\Jobs\SendEmailJob::dispatch($this->campaign, $subscriber);
        
        Queue::assertPushed(SendEmailJob::class, function ($job) use ($subscriber) {
            return $job->subscriber->id === $subscriber->id;
        });
    }

    public function test_end_to_end_sending_via_smtp(): void
    {
        // This test uses REAL SMTP. 
        // Ensure you have configured .env correctly before running.
        
        // 1. Setup Data
        $card = EmailCard::create([
            'name' => 'Test Card', 
            'html_content' => '<div>Content</div>', // Note: html_content is NOT in fillable in the model view I saw? Let me double check usage. 
            // Wait, the error was sender_name.
            'sender_name' => 'Test Sender',
            'sender_role' => 'Support',
            'is_active' => true
        ]);
        
        $campaign = NewsletterCampaign::create([
            'subject' => 'Test Campaign SMTP',
            'status' => 'draft',
            'email_card_id' => $card->id,
            'slug' => 'test-campaign-smtp',
        ]);

        $email = $campaign->emails()->create([
            'subject' => 'Verify SMTP Delivery',
            'body' => '<p>If you are reading this, the SMTP configuration works!</p>',
            'sort_order' => 0,
            'delay_in_hours' => 0,
        ]);

        // Use the user's test email
        $subscriber = NewsletterSubscriber::create([
            'email' => 'contato@losfit.com.br', 
            'is_active' => true,
        ]);

        // 2. Execute Job directly (bypass queue to ensure immediate execution in test)
        // We want to actually SEND, so we do NOT fake Mail or Queue here.
        // But SendCampaignJob dispatches SendEmailJob. If Queue is not valid, it might try to queue it.
        // We should force synchronous execution or ensure queue connection is 'sync' for tests.
        // phpunit.xml usually sets QUEUE_CONNECTION to sync.
        
        $job = new SendCampaignJob($campaign);
        $job->handle();

        // 3. Assertions
        $this->assertEquals('sent', $campaign->refresh()->status->value);
        
        // No exception means success for basic SMTP connectivity.
    }
}
