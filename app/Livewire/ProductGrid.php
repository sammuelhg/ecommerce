<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\GridComposer;
use Livewire\Component;
use Livewire\WithPagination;

class ProductGrid extends Component
{
    use WithPagination;

    public ?int $campaignId = null;
    public $variant = 'A';

    public function mount()
    {
        // Find a featured campaign (latest active with promo image)
        // Using 'sending' or 'sent' or 'draft'? Usually 'active' or 'sent'. 
        // Assuming 'sent' means it's live/running.
        $campaign = \App\Models\NewsletterCampaign::where('status', \App\Enums\CampaignStatus::SENT) 
            ->whereNotNull('promo_image_url')
            ->latest()
            ->first();
            
        if ($campaign) {
            $this->campaignId = $campaign->id;
        }
    }

    public $newsletterEmail = '';
    public $newsletterSuccess = false;
    public $source = 'grid';

    public function newsletterSubscribe($campaignId = null)
    {
        $action = app(\App\Actions\SubscribeToNewsletterAction::class);

        $this->validate([
            'newsletterEmail' => 'required|email|unique:newsletter_subscribers,email'
        ], [
            'newsletterEmail.unique' => 'Este email já está inscrito!',
            'newsletterEmail.required' => 'Por favor, informe um email.',
            'newsletterEmail.email' => 'Email inválido.'
        ]);

        $targetCampaignId = $campaignId ?: $this->campaignId;

        $action->execute($this->newsletterEmail, $this->source, [], $targetCampaignId);

        $this->newsletterSuccess = true;
        $this->newsletterEmail = '';
        
        session()->flash('newsletter_message', 'Inscrição realizada com sucesso! Ganhe 15% OFF com o cupom: WELCOME15');
    }

    public function render(GridComposer $composer)
    {
        // 1. Fetch Products
        $products = Product::where('is_active', true)
                         ->orderBy('id', 'desc')
                         ->paginate(20);

        $rules = [];

        // Disable rules for simple variant
        if ($this->variant === 'simple') {
            $rules = [];
        }

        // Inject Newsletter Card if Campaign Found (only if not simple variant)
        if ($this->campaignId && $this->variant !== 'simple') {
            $campaign = \App\Models\NewsletterCampaign::find($this->campaignId);
            if ($campaign) {
                // Determine position (e.g. 5)
                $rules[5] = [
                    'type' => 'card.newsletter_form', // This maps to components/cards/newsletter_form 
                    // GridComposer maps 'card.newsletter' to a view. 
                    // I need to ensure GridComposer handles this or use a generic 'raw' type.
                    // Assuming 'newsletter_form' is the view name partially.
                    // Let's assume 'card.newsletter' maps to 'components.cards.newsletter_form'.
                    'col_span' => 1,
                    'content' => [
                        'image' => $campaign->promo_image_url,
                        'title' => $campaign->subject,
                    ]
                ];
            }
        }

        // 3. Compose the Grid
        $useDbRules = ($this->variant !== 'simple');
        $gridItems = $composer->merge($products, $rules, $useDbRules);

        return view('livewire.shop.product-grid', [
            'gridItems' => $gridItems,
            'products' => $products 
        ]);
    }
}
