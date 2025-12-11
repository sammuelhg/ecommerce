<?php

namespace Tests\Feature;

use App\Actions\SendContactEmailAction;
use App\DTOs\ContactDTO;
use App\Jobs\SendEmailJob;
use App\Models\Contact;
use App\Models\EmailCard;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterSubscriber;
use App\Models\StoreSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ContactFormAutoResponseTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_submission_saves_to_database(): void
    {
        Mail::fake();

        $dto = new ContactDTO(
            name: 'John Doe',
            email: 'john@example.com',
            phone: '1234567890',
            message: 'Test message'
        );

        $action = new SendContactEmailAction();
        $action->execute($dto);

        $this->assertDatabaseHas('contacts', [
            'email' => 'john@example.com',
            'message' => 'Test message',
        ]);
    }

    public function test_auto_response_triggered_when_configured(): void
    {
        Mail::fake();
        Queue::fake();

        // 1. Setup Campaign
        $card = EmailCard::create([
            'name' => 'Test Card', 
            'sender_name' => 'Auto Responder',
            'sender_role' => 'System',
            'html_content' => '<div>Hi</div>', 
            'is_active' => true
        ]);
        
        $campaign = NewsletterCampaign::create([
            'subject' => 'Welcome!',
            'status' => 'sent',
            'email_card_id' => $card->id,
            'slug' => 'welcome-campaign',
        ]);

        $campaign->emails()->create([
            'subject' => 'Welcome Email',
            'body' => 'Welcome Body',
            'sort_order' => 0,
            'delay_in_hours' => 0,
        ]);

        // 2. Configure Auto-Response
        StoreSetting::set('contact_auto_response_campaign_id', $campaign->id);

        // 3. Submit Form
        $dto = new ContactDTO(
            name: 'Jane Smith',
            email: 'jane@example.com',
            phone: '0987654321',
            message: 'Hello'
        );

        $action = new SendContactEmailAction();
        $action->execute($dto);

        // 4. Assertions
        // Verify Contact Saved
        $this->assertDatabaseHas('contacts', ['email' => 'jane@example.com']);
        
        // Verify Subscriber Created
        $this->assertDatabaseHas('newsletter_subscribers', ['email' => 'jane@example.com']);

        // Verify Job Dispatched
        Queue::assertPushed(SendEmailJob::class, function ($job) use ($campaign) {
            return $job->campaign->id === $campaign->id;
        });
    }
}
