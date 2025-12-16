<?php

declare(strict_types=1);

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Services\CartService;
use App\DTOs\Cart\CartItemDTO;
use Illuminate\Contracts\View\View;

class ProductCard extends Component
{
    // 1. Definição Obrigatória: A propriedade deve ser pública e tipada
    public Product $product;

    // 2. Estado local para interações
    public bool $isAddingToCart = false;

    // 3. Mount Opcional (O Livewire 3 faz o binding automático, mas isso valida)
    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    public function render(): View
    {
        return view('livewire.shop.product-card');
    }

    public function addToCart(CartService $cart): void
    {
        $this->isAddingToCart = true;

        // Use the Service to add to cart
        $dto = new CartItemDTO($this->product->id, 1);
        $cart->add($dto);
        
        $this->dispatch('cartUpdated');
        $this->dispatch('toast-success', message: 'Produto adicionado ao carrinho!');

        $this->isAddingToCart = false;
    }
}
