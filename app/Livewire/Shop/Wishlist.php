<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Services\WishlistService;
use App\Services\CartService;
use App\Models\Product;
use Livewire\Attributes\On;

use App\DTOs\Cart\CartItemDTO;

class Wishlist extends Component
{
    // ... items ...

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
                $dto = new CartItemDTO($product->id, 1);
                $this->cartService->add($dto);
                $this->dispatch('cartUpdated');
                $this->dispatch('toast-success', 'Produto movido para o carrinho!');
            }
        }
    }
}
