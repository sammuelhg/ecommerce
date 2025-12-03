<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Services\WishlistService;
use App\Services\CartService;

class AddToCartButton extends Component
{
    public Product $product;
    public bool $inWishlist = false;

    public function mount(WishlistService $wishlist)
    {
        $this->inWishlist = $wishlist->has($this->product->id);
    }

    public function addToCart(int $quantity, CartService $cart)
    {
        // Validate quantity
        $quantity = max(1, min($quantity, (int) $this->product->stock));
        
        $cart->add($this->product, $quantity);
        $this->dispatch('cartUpdated');
        
        // Dispatch event for Client-Side Alpine Cart
        $this->dispatch('add-to-cart', [
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'image' => $this->product->image,
                'slug' => $this->product->slug,
            ],
            'quantity' => $quantity
        ]);
        
        // Toast is now shown optimistically on client-side for instant feedback
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
        return view('livewire.shop.add-to-cart-button');
    }
}
