<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Services\WishlistService;
use App\Services\CartService;

class ProductCard extends Component
{
    public Product $product;
    public bool $inWishlist = false;

    public function mount(WishlistService $wishlist)
    {
        $this->inWishlist = $wishlist->has($this->product->id);
    }

    public function addToCart(CartService $cart)
    {
        $cart->add($this->product);
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
