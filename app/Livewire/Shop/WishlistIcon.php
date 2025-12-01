<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Services\WishlistService;
use Livewire\Attributes\On;

class WishlistIcon extends Component
{
    protected $wishlistService;

    public function boot(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    #[On('wishlistUpdated')]
    public function render()
    {
        return view('livewire.shop.wishlist-icon', [
            'count' => $this->wishlistService->count()
        ]);
    }
}
