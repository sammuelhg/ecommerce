<?php

declare(strict_types=1);

namespace App\Livewire\Integrations;

use Livewire\Component;
use App\DTOs\Integrations\TikTokConnectData;
use App\Actions\Integrations\UpsertTikTokIntegrationAction;
use App\Models\Integration;
use Exception;

class TikTokSettings extends Component
{
    public string $advertiserId = '';
    public string $accessToken = '';
    public string $pixelId = '';
    public bool $isActive = false;

    public function mount(): void
    {
        $integration = Integration::where('provider', 'tiktok_ads')->first();

        if ($integration) {
            $creds = $integration->credentials ?? [];
            
            $this->advertiserId = $creds['advertiser_id'] ?? '';
            $this->accessToken = $creds['access_token'] ?? '';
            $this->pixelId = $creds['pixel_id'] ?? '';
            $this->isActive = $integration->is_active;
        }
    }

    public function save(UpsertTikTokIntegrationAction $action): void
    {
        $this->validate([
            'advertiserId' => 'required|string',
            'accessToken' => 'required|string',
            'pixelId' => 'required|string',
        ]);

        try {
            $dto = new TikTokConnectData(
                advertiserId: $this->advertiserId,
                accessToken: $this->accessToken,
                pixelId: $this->pixelId,
                isActive: $this->isActive
            );

            $action->execute($dto);

            session()->flash('success', 'Integração TikTok Ads salva com sucesso!');
        } catch (Exception $e) {
            $this->addError('integration_error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.integrations.tiktok-settings');
    }
}
