<?php

namespace App\Livewire\Admin\Marketing;

use Livewire\Component;

class SearchHighlights extends Component
{
    public $selectedCategory = null; 
    public $searchProduct = '';

    public function mount()
    {
        $this->selectedCategory = 'global'; // Start with Global
    }

    public function addProduct($productId)
    {
        $categoryId = $this->selectedCategory === 'global' ? null : $this->selectedCategory;

        // Check if already exists
        $exists = \App\Domains\Content\Models\SearchHighlight::where('category_id', $categoryId)
            ->where('product_id', $productId)
            ->exists();

        if (!$exists) {
            \App\Domains\Content\Models\SearchHighlight::create([
                'category_id' => $categoryId,
                'product_id' => $productId,
            ]);
        }
        
        $this->searchProduct = ''; // Clear search
    }

    public function removeHighlight($id)
    {
        \App\Domains\Content\Models\SearchHighlight::destroy($id);
    }

    public function render()
    {
        $categories = \App\Domains\Catalog\Models\Category::where('is_active', true)->orderBy('name')->get();
        
        $categoryId = $this->selectedCategory === 'global' ? null : $this->selectedCategory;

        $highlights = \App\Domains\Content\Models\SearchHighlight::with('product')
            ->where('category_id', $categoryId)
            ->latest()
            ->get();

        $searchResults = [];
        if (strlen($this->searchProduct) > 2) {
            $existingIds = $highlights->pluck('product_id')->toArray();
            
            $searchResults = \App\Domains\Catalog\Models\Product::where('is_active', true)
                ->where('name', 'like', '%' . $this->searchProduct . '%')
                ->whereNotIn('id', $existingIds)
                ->take(10)
                ->get();
        }

        return view('livewire.admin.marketing.search-highlights', [
            'categories' => $categories,
            'highlights' => $highlights,
            'searchResults' => $searchResults
        ]);
    }
}
