<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductDetails extends Component
{
    public $slug;
    public $quantity = 1;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        // Placeholder for cart functionality
        // We will implement the actual cart logic in the next phase
        session()->flash('message', 'Produto adicionado ao carrinho! (Simulação)');
        
        // Dispatch event for cart icon update (future implementation)
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $product = Product::where('slug', $this->slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('livewire.product-details', [
            'product' => $product,
            'relatedProducts' => Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->take(4)
                ->get()
        ])->layout('layouts.app');
    }
}
