<?php

declare(strict_types=1);

namespace App\Actions\Integrations;

use App\DTOs\Integrations\MetaConnectData;
use App\Models\Integration;
use App\Services\AdNetworks\MetaAdsService;
use Exception;

final class UpsertMetaIntegrationAction
{
    public function __construct(
        protected MetaAdsService $service
    ) {}

    public function execute(MetaConnectData $data): Integration
    {
        $credentials = $data->toArray();

        // 1. Validar conexao antes de salvar
        if ($data->isActive && !$this->service->validateConnection($credentials)) {
            throw new Exception('Não foi possível validar as credenciais com o Meta Ads.');
        }

        // 2. Upsert (Atualizar ou Criar) usando Provider como chave
        return Integration::updateOrCreate(
            ['provider' => 'meta_ads'],
            [
                'name' => 'Meta Ads Principal',
                'credentials' => $credentials, // O Model encarrega-se de criptografar
                'is_active' => $data->isActive,
            ]
        );
    }
}
