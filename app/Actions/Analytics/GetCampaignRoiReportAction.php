<?php

declare(strict_types=1);

namespace App\Actions\Analytics;

use App\Models\Campaign;

class GetCampaignRoiReportAction
{
    /**
     * Gera um relatório de ROI consolidado para uma campanha.
     * 
     * @param string|int $campaignId
     * @return array
     */
    public function execute($campaignId): array
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::findOrFail($campaignId);

        // 1. Dados Básicos
        $sentCount = $campaign->emails->sum(fn($email) => $email->sent_count ?? 0); // Assuming email has sent_count or we calculate from logs
        // Falling back to 0 if not tracked yet
        
        // 2. Métricas de Engajamento (Opens)
        // Count unique subscribers who opened
        $uniqueOpens = $campaign->opens()
            ->distinct('newsletter_subscriber_id')
            ->count('newsletter_subscriber_id');
            
        $totalOpens = $campaign->opens()->count();

        // 3. Métricas de Conversão (Revenue)
        $revenue = (float) $campaign->generated_revenue;
        $conversions = (int) $campaign->conversion_count;

        // 4. Cálculos de Performance
        $openRate = $sentCount > 0 ? ($uniqueOpens / $sentCount) * 100 : 0;
        $conversionRate = $uniqueOpens > 0 ? ($conversions / $uniqueOpens) * 100 : 0; // Conversion from Open
        // Or conversion from Sent:
        $globalConversionRate = $sentCount > 0 ? ($conversions / $sentCount) * 100 : 0;

        $averageOrderValue = $conversions > 0 ? $revenue / $conversions : 0;

        return [
            'campaign_id' => $campaign->id,
            'campaign_name' => $campaign->name,
            'metrics' => [
                'sent' => $sentCount, // TODO: Implementar rastreamento real de envios em CampaignEmail
                'opens_unique' => $uniqueOpens,
                'opens_total' => $totalOpens,
                'open_rate' => round($openRate, 2),
                'conversions' => $conversions,
                'revenue' => $revenue,
                'conversion_rate_from_open' => round($conversionRate, 2),
                'average_order_value' => round($averageOrderValue, 2),
            ],
            'currency' => 'BRL'
        ];
    }
}
