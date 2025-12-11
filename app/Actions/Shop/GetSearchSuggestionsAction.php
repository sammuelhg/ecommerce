<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Models\Category;
use App\Models\Product;
use App\Models\SearchHighlight;
use Illuminate\Database\Eloquent\Collection;

class GetSearchSuggestionsAction
{
    public function execute(?string $query, ?string $categorySlug): array
    {
        // CASE: Default Suggestions (Search Highlights)
        if (empty($query)) {
            return $this->getHighlights($categorySlug);
        }

        // CASE: Active Typing Search
        if (strlen($query) < 2) {
            return ['products' => [], 'categories' => []];
        }

        return $this->searchActive($query);
    }

    private function getHighlights(?string $categorySlug): array
    {
        $categoryId = null;
        
        if ($categorySlug && $categorySlug !== 'Todos') {
            $category = Category::where('slug', $categorySlug)->first();
            $categoryId = $category?->id;
        }

        // 1. Try to get configured highlights
        $highlights = SearchHighlight::with('product')
            ->where('category_id', $categoryId)
            ->limit(3)
            ->get()
            ->pluck('product');

        // 2. Fallback logic
        if ($highlights->count() < 3) {
            $needed = 3 - $highlights->count();
            $excludeIds = $highlights->pluck('id')->toArray();
            
            $fillerQuery = Product::where('is_active', true)->whereNotIn('id', $excludeIds);
            
            if ($categoryId) {
                $fillerQuery->where(function($q) use ($categoryId) {
                    $q->where('category_id', $categoryId)
                      ->orWhereHas('categories', function($sq) use ($categoryId) {
                          $sq->where('categories.id', $categoryId);
                      });
                });
            }
            
            $fillers = $fillerQuery->inRandomOrder()->limit($needed)->get();
            
            if ($highlights->count() + $fillers->count() < 3) {
                $stillNeeded = 3 - ($highlights->count() + $fillers->count());
                $globalFillers = Product::where('is_active', true)
                   ->whereNotIn('id', array_merge($excludeIds, $fillers->pluck('id')->toArray()))
                   ->inRandomOrder()
                   ->limit($stillNeeded)
                   ->get();
                $fillers = $fillers->merge($globalFillers);
            }
            
            $highlights = $highlights->merge($fillers);
        }

        $products = $highlights->take(3)->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'image' => $p->image
            ];
        });

        return [
            'products' => $products,
            'categories' => []
        ];
    }

    private function searchActive(string $query): array
    {
        $products = Product::where('name', 'like', "%{$query}%")
            ->where('is_active', true)
            ->limit(5)
            ->get(['id', 'name', 'slug', 'image']);

        $categories = Category::where('name', 'like', "%{$query}%")
            ->where('is_active', true)
            ->limit(3)
            ->get(['id', 'name', 'slug']);

        return [
            'products' => $products,
            'categories' => $categories
        ];
    }
}
