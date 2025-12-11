<?php

declare(strict_types=1);

namespace App\Livewire\Integrations;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Integration;
use App\DTOs\Integrations\MetaConnectData;
use App\Actions\Integrations\UpsertMetaIntegrationAction;

class MetaSettings extends Component
{
    #[Validate('required|string|min:5')]
    public string $pixelId = '';

    #[Validate('required|string|min:5')]
    public string $adAccountId = '';

    #[Validate('required|string|min:10')]
    public string $accessToken = '';

    public bool $isActive = false;

    public function mount(): void
    {
        $integration = Integration::where('provider', 'meta_ads')->first();

        if ($integration) {
            $creds = $integration->credentials; // Descriptografia automática
            $this->pixelId = $creds['pixel_id'] ?? '';
            $this->adAccountId = $creds['ad_account_id'] ?? '';
            $this->accessToken = $creds['access_token'] ?? '';
            $this->isActive = $integration->is_active;
        }
    }

    public function save(UpsertMetaIntegrationAction $action): void
    {
        $this->validate();

        try {
            $dto = new MetaConnectData(
                adAccountId: $this->adAccountId,
                pixelId: $this->pixelId,
                accessToken: $this->accessToken,
                isActive: $this->isActive
            );

            $action->execute($dto);

            session()->flash('success', 'Integração Meta Ads salva com sucesso!');
        } catch (\Exception $e) {
            $this->addError('integration_error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.integrations.meta-settings');
    }
}
