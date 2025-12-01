<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Services\WishlistService;
use App\Services\CartService;
use App\Models\Product;
use Livewire\Attributes\On;

class Wishlist extends Component
{
    protected $wishlistService;
    protected $cartService;

    public function boot(WishlistService $wishlistService, CartService $cartService)
    {
        $this->wishlistService = $wishlistService;
        $this->cartService = $cartService;
    }

    #[On('wishlistUpdated')]
    public function render()
    {
        return view('livewire.shop.wishlist', [
            'wishlistItems' => $this->wishlistService->get()
        ]);
    }

    public function removeItem($id)
    {
        $this->wishlistService->remove($id);
        $this->dispatch('wishlistUpdated');
        $this->dispatch('toast-info', 'Produto removido da lista de desejos.');
    }

    public function moveToCart($id)
    {
        $items = $this->wishlistService->get();
        if (isset($items[$id])) {
            $product = Product::find($id);
            if ($product) {
                $this->cartService->add($product);
                $this->dispatch('cartUpdated');
                $this->dispatch('toast-success', 'Produto movido para o carrinho!');
            }
        }
    }
}
