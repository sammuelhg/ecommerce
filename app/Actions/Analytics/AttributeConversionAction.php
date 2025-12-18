<?php

declare(strict_types=1);

namespace App\Actions\Analytics;

use App\Domains\Sales\Models\Order;
use App\Domains\Marketing\Models\Campaign;
use App\DTOs\Analytics\ConversionEventDTO;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Actions\Integrations\SendConversionEventToMetaAction;

/**
 * Objetivo: Ligar uma venda (Order) a uma origem de tráfego (Campaign/Source).
 * Pilar 2 (Completude): Se houve venda, rastreamos a origem para o ROI.
 */
class AttributeConversionAction
{
    public function __construct(
        protected SendConversionEventToMetaAction $sendMetaEvent
    ) {}

    public function execute(ConversionEventDTO $data): void
    {
        // 1. Validação de Integridade
        if (!$data->order_id || !$data->total_value) {
            throw new \InvalidArgumentException("Impossível atribuir conversão sem ID do pedido ou valor.");
        }

        DB::transaction(function () use ($data) {
            // 2. Busca o pedido (Simulação de Model)
            $order = Order::findOrFail($data->order_id);
            
            // Tenta recuperar atribuição da sessão se não vier no DTO
            $campaignId = $data->campaign_id;
            $sourceType = $data->source_type;
            
            if (!$campaignId && session()->has('attribution')) {
                $attribution = session('attribution');
                $campaignId = $attribution['campaign_id'] ?? null;
                $sourceType = $attribution['source_type'] ?? $sourceType;
            }

            // 3. Lógica de Atribuição (Last Click)
            // Se veio de uma campanha de e-mail, registramos o sucesso nela.
            if ($campaignId && ($sourceType === 'email_campaign' || $sourceType === 'email')) {
                
                $campaign = Campaign::findOrFail($campaignId);
                
                // Incrementa receita da campanha (Desnormalização intencional para performance de Dashboard)
                if (\Schema::hasColumn('campaigns', 'generated_revenue')) {
                     $campaign->increment('generated_revenue', $data->total_value);
                }
                if (\Schema::hasColumn('campaigns', 'conversion_count')) {
                     $campaign->increment('conversion_count');
                }
                
                // 4. Observabilidade (Pilar 1 - Auditoria)
                Log::channel('daily')->info("Conversão atribuída", [
                    'order_id' => $order->id,
                    'campaign_id' => $campaign->id,
                    'value' => $data->total_value, // Valor do evento (pode ser diferente do total do pedido se for LTV)
                    'attribution_source' => 'session_last_click',
                    'timestamp' => now()->toIso8601String()
                ]);
            }

            // 5. Integração com AdTech (Se veio do Meta/Google, dispara o evento de API)
            $this->sendMetaEvent->execute($data);
        });
    }
}
