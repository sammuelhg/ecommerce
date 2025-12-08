<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Services\WishlistService;
use App\Services\CartService;

use App\DTOs\Cart\CartItemDTO;

class ProductCard extends Component
{
    // ... existed code ...

    public function addToCart(CartService $cart)
    {
        $dto = new CartItemDTO($this->product->id, 1);
        $cart->add($dto);
        $this->dispatch('cartUpdated');
        $this->dispatch('toast-success', message: 'Produto adicionado ao carrinho!');
    }

    public function toggleWishlist(WishlistService $wishlist)
    {
        $this->inWishlist = $wishlist->toggle($this->product);
        $this->dispatch('wishlistUpdated');
        
        if ($this->inWishlist) {
            $this->dispatch('toast-success', message: 'Produto adicionado à lista de desejos!');
        } else {
            $this->dispatch('toast-info', message: 'Produto removido da lista de desejos.');
        }
    }

    public function render()
    {
        return view('livewire.shop.product-card');
    }
}
