<?php

declare(strict_types=1);

namespace App\Services\AdNetworks;

use App\Interfaces\AdNetworkInterface;
use Illuminate\Support\Facades\Log;

class TikTokAdsService implements AdNetworkInterface
{
    /**
     * Validate TikTok credentials.
     */
    public function validateConnection(array $credentials): bool
    {
        $advertiserId = $credentials['advertiser_id'] ?? '';
        $accessToken = $credentials['access_token'] ?? '';
        $pixelId = $credentials['pixel_id'] ?? '';

        if (empty($advertiserId) || empty($accessToken) || empty($pixelId)) {
            return false;
        }

        // Basic format validation (Advertiser ID usually numeric)
        if (!preg_match('/^\d+$/', $advertiserId)) {
            return false;
        }

        return true;
    }

    /**
     * Placeholder for TikTok Events API.
     */
    public function sendEvent(string $eventName, array $payload): void
    {
        // TODO: Implement TikTok Events API
        // Doc: https://ads.tiktok.com/marketing_api/docs
        Log::info('TikTok Ads Event Dispatched (Simulation)', ['event' => $eventName, 'payload' => $payload]);
    }
}
