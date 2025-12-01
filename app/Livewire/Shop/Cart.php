<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Services\CartService;
use Livewire\Attributes\On;

class Cart extends Component
{
    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[On('cartUpdated')]
    public function render()
    {
        return view('livewire.shop.cart', [
            'cartItems' => $this->cartService->get(),
            'total' => $this->cartService->total()
        ]);
    }

    public function removeItem($id)
    {
        $this->cartService->remove($id);
        $this->dispatch('cartUpdated');
        $this->dispatch('toast-error', 'Produto removido do carrinho.');
    }

    public function updateQty($id, $qty)
    {
        $this->cartService->update($id, $qty);
        $this->dispatch('cartUpdated');
    }
}
