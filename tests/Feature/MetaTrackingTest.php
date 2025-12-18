<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Actions\Integrations\SendConversionEventToMetaAction;
use App\Services\AdNetworks\MetaAdsService;
use App\DTOs\Analytics\ConversionEventDTO;
use App\Models\Integration;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MetaTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sends_conversion_event_when_integration_is_active()
    {
        // 1. Setup Integration
        Integration::create([
            'provider' => 'meta_ads',
            'name' => 'Meta Test',
            'is_active' => true,
            'credentials' => [
                'access_token' => 'fake_token',
                'pixel_id' => '123456',
                'test_event_code' => 'TEST1234'
            ]
        ]);

        // 2. Mock HTTP
        Http::fake([
            'graph.facebook.com/*' => Http::response(['success' => true], 200)
        ]);

        // 3. Create Action
        $service = new MetaAdsService();
        $action = new SendConversionEventToMetaAction($service);

        // 4. Execute
        $dto = new ConversionEventDTO(
            order_id: 'ORDER-123',
            total_value: 100.50,
            customer_email: 'test@example.com'
        );

        $action->execute($dto);

        // 5. Assertions
        Http::assertSent(function ($request) {
            return $request->url() == 'https://graph.facebook.com/v19.0/123456/events'
                && $request['data'][0]['event_name'] == 'Purchase'
                && $request['data'][0]['custom_data']['value'] == 100.50
                && $request['data'][0]['custom_data']['order_id'] == 'ORDER-123'
                && $request['data'][0]['user_data']['em'] == hash('sha256', 'test@example.com');
        });
    }

    public function test_it_does_not_send_event_if_integration_inactive()
    {
        // 1. Setup Integration (Inactive)
        Integration::create([
            'provider' => 'meta_ads',
            'name' => 'Meta Test',
            'is_active' => false,
            'credentials' => ['access_token' => 'x', 'pixel_id' => 'y']
        ]);

        Http::fake();

        // 2. Execute
        $service = new MetaAdsService();
        $action = new SendConversionEventToMetaAction($service);
        
        $dto = new ConversionEventDTO(
            order_id: 'ORDER-123',
            total_value: 100.50
        );

        $action->execute($dto);

        // 3. Assert Nothing Sent
        Http::assertNothingSent();
    }
}
