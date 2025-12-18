<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Domains\Marketing\Models\Lead;
use App\Domains\Marketing\Models\NewsletterCampaign;
use App\Domains\Marketing\Models\NewsletterEmail;
use App\Mail\CampaignEmail;
use App\Mail\ContactFormMail;
use App\Mail\HighlightsEmail;
use App\DTOs\ContactDTO;
use App\DTOs\HighlightsDTO;

echo "--- Starting Email Test ---\n";

$testEmail = 'test@example.com';

// 1. Test Campaign Email
echo "1. Testing Campaign Email...\n";
$campaign = NewsletterCampaign::first() ?? NewsletterCampaign::create([
    'name' => 'Test Campaign',
    'subject' => 'Test Subject',
    'status' => \App\Enums\CampaignStatus::DRAFT,
    'slug' => 'test-campaign-' . time()
]);

$emailModel = $campaign->emails()->first() ?? $campaign->emails()->create([
    'subject' => 'Test Email Step',
    'body' => '<p>Hello {{ $user->name }}!</p>',
    'step_order' => 1
]);

$lead = Lead::first() ?? Lead::create([
    'email' => $testEmail,
    'name' => 'Test Lead',
    'source' => 'test'
]);

try {
    Mail::to($testEmail)->send(new CampaignEmail($emailModel, $lead));
    echo "✓ Campaign Email trigger successful.\n";
} catch (\Exception $e) {
    echo "✗ Campaign Email failed: " . $e->getMessage() . "\n";
}

// 2. Test Contact Form Email
echo "2. Testing Contact Form Email...\n";
$contactDto = new ContactDTO(
    name: 'Jane Smith',
    email: 'jane@example.com',
    phone: '123456789',
    message: 'I am interested in your products.'
);

try {
    Mail::to($testEmail)->send(new ContactFormMail($contactDto));
    echo "✓ Contact Form Email trigger successful.\n";
} catch (\Exception $e) {
    echo "✗ Contact Form Email failed: " . $e->getMessage() . "\n";
}

// 3. Test Grid Highlights Email
echo "3. Testing Grid Highlights Email...\n";
$highlightsDto = new HighlightsDTO(
    title: 'New Collections',
    subtitle: 'Check out our latest arrivals',
    imageUrl: 'https://example.com/image.jpg',
    ctaText: 'Shop Now',
    ctaUrl: 'https://example.com/shop',
    items: []
);

try {
    Mail::to($testEmail)->send(new HighlightsEmail($highlightsDto));
    echo "✓ Highlights Email trigger successful.\n";
} catch (\Exception $e) {
    echo "✗ Highlights Email failed: " . $e->getMessage() . "\n";
}

echo "\nTests finished. Check storage/logs/laravel.log if you are using 'log' driver.\n";
