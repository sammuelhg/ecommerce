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
        // Inject dependencies if not in constructor
        $service = app(WishlistService::class); 
        $service->remove($id);
        
        // Dispatch generic update for header icon
        $this->dispatch('wishlistUpdated'); 
        
        // Dispatch specific update for Product Cards
        // Use explicit array to guarantee JS receives it as event.detail[0]
        $this->dispatch('wishlist-updated', ['id' => $id, 'is_favorite' => false]);
        
        $this->dispatch('toast-info', message: 'Produto removido da lista de desejos.');
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
                $this->dispatch('toast-success', message: 'Produto movido para o carrinho!');
            }
        }
    }

    #[On('toggle-wishlist')]
    public function toggle($data)
    {
        // $data is strictly the array ['id' => 123]
        $id = $data['id'] ?? null;
        if (!$id) return;
        
        // Find real model to pass to service
        $model = Product::find($id);
        if (!$model) return;

        $isAdded = $this->wishlistService->toggle($model);
        
        // Notify UI components
        $this->dispatch('wishlistUpdated'); // Global count
        $this->dispatch('wishlist-updated', ['id' => $model->id, 'is_favorite' => $isAdded]);
        
        $msg = $isAdded ? 'Adicionado à lista de desejos!' : 'Removido da lista de desejos.';
        // Use appropriate toast type
        if ($isAdded) {
            $this->dispatch('toast-success', message: $msg);
        } else {
            $this->dispatch('toast-info', message: $msg);
        }
    }
}
