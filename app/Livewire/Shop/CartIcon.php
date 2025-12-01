<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Services\CartService;
use Livewire\Attributes\On;

class CartIcon extends Component
{
    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[On('cartUpdated')]
    public function render()
    {
        return view('livewire.shop.cart-icon', [
            'count' => $this->cartService->count()
        ]);
    }
}
