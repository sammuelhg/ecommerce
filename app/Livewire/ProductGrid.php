<?php

namespace App\Livewire;

use App\Domains\Catalog\Models\Product;
use App\Domains\Catalog\Services\GridComposer;
use Livewire\Component;
use Livewire\WithPagination;

use App\DTOs\Cart\CartItemDTO;
use App\Domains\Sales\Services\CartService;
use App\Actions\Shop\ListStoreFrontProductsAction;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductGrid extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public ?int $campaignId = null;
    public $variant = 'A';

    public function mount()
    {
        // Find a featured campaign (latest active with promo image)
        // Using 'sending' or 'sent' or 'draft'? Usually 'active' or 'sent'. 
        // Assuming 'sent' means it's live/running.
        // $campaign = \App\Domains\Marketing\Models\NewsletterCampaign::where('status', \App\Enums\CampaignStatus::SENT) 
        //    ->whereNotNull('promo_image_url')
        //    ->latest()
        //    ->first();
            
        // if ($campaign) {
        //    $this->campaignId = $campaign->id;
        // }
    }

    public function addToCart(int $productId, CartService $cart)
    {
        $dto = new CartItemDTO($productId, 1);
        $cart->add($dto);
        $this->dispatch('cartUpdated');
        $this->dispatch('toast-success', message: 'Produto adicionado ao carrinho!');
    }

    // Injeção de dependência no método render é o padrão do Livewire para Actions stateless
    public function render(
        ListStoreFrontProductsAction $listProducts,
        GridComposer $composer
    ): View {
        // 1. Busca os dados brutos via Action
        $products = $listProducts->execute(16);

        // 2. Diagnóstico de Grid
        Log::info("ProductGrid: Enviando " . $products->count() . " produtos para o GridComposer.");

        $rules = [];
        // Disable rules for simple variant if needed
        if ($this->variant === 'simple') {
             // Keep rules empty
             $useDbRules = false;
        } else {
             $useDbRules = true;
        }

        // 3. Mescla Produtos com Regras de Layout (Banners, Destaques)
        try {
            $gridItems = $composer->merge($products, $rules, $useDbRules); 
        } catch (\Exception $e) {
            Log::error("ProductGrid: Erro fatal no GridComposer: " . $e->getMessage());
            // Fallback: mostra apenas os produtos se o grid falhar
            $gridItems = $products->getCollection(); 
        }

        return view('livewire.shop.product-grid', [
            'gridItems' => $gridItems,
            'products'  => $products // Necessário para a paginação funcionar na view
        ]);
    }
}
