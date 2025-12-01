<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Services\WishlistService;
use App\Services\CartService;

class AddToCartButton extends Component
{
    public Product $product;
    public int $quantity = 1;
    public bool $inWishlist = false;

    public function mount(WishlistService $wishlist)
    {
        $this->inWishlist = $wishlist->has($this->product->id);
    }

    public function addToCart(CartService $cart)
    {
        $cart->add($this->product, $this->quantity);
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

    public function increment()
    {
        if ($this->quantity < (int) $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        return view('livewire.shop.add-to-cart-button');
    }
}
