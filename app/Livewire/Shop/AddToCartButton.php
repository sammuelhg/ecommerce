<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Services\WishlistService;
use App\Services\CartService;

use App\DTOs\Cart\CartItemDTO;

class AddToCartButton extends Component
{
    // ... items ...

    public function addToCart(int $quantity, CartService $cart)
    {
        // Validate quantity
        $quantity = max(1, min($quantity, (int) $this->product->stock));
        
        $dto = new CartItemDTO($this->product->id, $quantity);
        $cart->add($dto);
        
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
