<?php

declare(strict_types=1);

namespace App\Actions\Campaign;

use App\Models\Campaign;
use App\Models\Lead;

class CompileEmailContentAction
{
    public function __construct(
        protected RenderSignCardAction $renderSignCard,
        protected RenderProductsVitrineAction $renderProducts
    ) {}

    public function execute(Campaign $campaign, Lead $lead): string
    {
        // 1. Get Base Content
        $content = $campaign->email_content_body ?? '';

        // 2. Token Replacement
        $replacements = [
            '{name}' => explode(' ', $lead->name ?? 'Cliente')[0], // First name
            '{email}' => $lead->email,
        ];

        foreach ($replacements as $key => $value) {
            $content = str_replace($key, $value, $content);
        }

        // 3. Render Vitrine (if products exist)
        $productsHtml = '';
        if ($campaign->products->isNotEmpty()) {
            $productsHtml = $this->renderProducts->execute($campaign->products);
        }
        
        // 4. Render Sign Card
        $signCardHtml = $this->renderSignCard->execute($campaign->signCard);

        // 5. Assemble
        // Simple stacking: Content -> Vitrine -> Signature
        // Wrapped in a main container for centering
        return <<<HTML
        <div style="font-family: sans-serif; color: #333333; line-height: 1.6; max-width: 600px; margin: 0 auto;">
            <div style="padding: 20px;">
                {$content}
            </div>
            
            {$productsHtml}
            
            <div style="padding: 20px;">
                {$signCardHtml}
            </div>
            
            <div style="text-align: center; margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; font-size: 11px; color: #999;">
                <p>Enviado com carinho por <a href="#" style="color: #999;">LosFit</a>.</p>
                <p><a href="#" style="color: #999; text-decoration: underline;">Descadastrar</a></p>
            </div>
        </div>
HTML;
    }
}
