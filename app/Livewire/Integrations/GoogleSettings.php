<?php

declare(strict_types=1);

namespace App\Livewire\Integrations;

use Livewire\Component;
use App\DTOs\Integrations\GoogleConnectData;
use App\Actions\Integrations\UpsertGoogleIntegrationAction;
use App\Models\Integration;
use Exception;

class GoogleSettings extends Component
{
    public string $customerId = '';
    public string $developerToken = '';
    public string $conversionActionId = '';
    public bool $isActive = false;

    public function mount(): void
    {
        $integration = Integration::where('provider', 'google_ads')->first();

        if ($integration) {
            $creds = $integration->credentials ?? []; // Model casts this automatically
            
            $this->customerId = $creds['customer_id'] ?? '';
            $this->developerToken = $creds['developer_token'] ?? '';
            $this->conversionActionId = $creds['conversion_action_id'] ?? '';
            $this->isActive = $integration->is_active;
        }
    }

    public function save(UpsertGoogleIntegrationAction $action): void
    {
        $this->validate([
            'customerId' => 'required|string',
            'developerToken' => 'required|string',
            'conversionActionId' => 'nullable|string',
        ]);

        try {
            $dto = new GoogleConnectData(
                customerId: $this->customerId,
                developerToken: $this->developerToken,
                conversionActionId: $this->conversionActionId,
                isActive: $this->isActive
            );

            $action->execute($dto);

            session()->flash('success', 'Integração Google Ads salva com sucesso!');
        } catch (Exception $e) {
            $this->addError('integration_error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.integrations.google-settings');
    }
}
