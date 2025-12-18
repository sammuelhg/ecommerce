<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Domains\Catalog\Models\Category;
use App\Domains\Catalog\Models\Product;
use App\Domains\Content\Models\SearchHighlight;
use Illuminate\Database\Eloquent\Collection;

class GetSearchSuggestionsAction
{
    public function execute(?string $query, ?string $categorySlug): array
    {
        $start = microtime(true);
        \Illuminate\Support\Facades\Log::info("GetSearchSuggestionsAction started", ['q' => $query, 'cat' => $categorySlug]);

        // CASE: Default Suggestions (Search Highlights)
        if (empty($query)) {
            $cacheKey = 'search_highlights_v2_' . ($categorySlug ?? 'all');
            $res = \Illuminate\Support\Facades\Cache::remember($cacheKey, 300, function() use ($categorySlug) {
                return $this->getHighlights($categorySlug);
            });
            \Illuminate\Support\Facades\Log::info("GetSearchSuggestionsAction finished (highlights)", ['time' => microtime(true) - $start]);
            return $res;
        }

        // CASE: Active Typing Search
        if (strlen($query) < 2) {
            return ['products' => [], 'categories' => []];
        }

        $cacheKey = 'search_active_v2_' . md5($query . ($categorySlug ?? 'all'));
        $res = \Illuminate\Support\Facades\Cache::remember($cacheKey, 60, function() use ($query, $categorySlug) {
            return $this->searchActive($query, $categorySlug);
        });

        \Illuminate\Support\Facades\Log::info("GetSearchSuggestionsAction finished (search)", ['time' => microtime(true) - $start]);
        return $res;
    }

    private function getHighlights(?string $categorySlug): array
    {
        $categoryId = null;
        
        if ($categorySlug && $categorySlug !== 'Todos') {
            // Hotfix: if it passed as JSON string
            if (str_starts_with($categorySlug, '{')) {
                try {
                   $obj = json_decode($categorySlug, true);
                   $categorySlug = $obj['slug'] ?? $categorySlug;
                } catch(\Exception $e) {}
            }

            $category = Category::where('slug', $categorySlug)->first(['id']);
            $categoryId = $category?->id;
        }

        // 1. Try to get configured highlights
        $highlights = SearchHighlight::with(['product' => function($q) {
            $q->select(['id', 'name', 'slug', 'image', 'price']);
        }])
            ->where('category_id', $categoryId)
            ->limit(3)
            ->get()
            ->pluck('product')
            ->filter();

        // 2. Fallback logic
        if ($highlights->count() < 3) {
            $needed = 3 - $highlights->count();
            $excludeIds = $highlights->pluck('id')->toArray();
            
            $fillerQuery = Product::query()
                ->select(['id', 'name', 'slug', 'image', 'price'])
                ->where('is_active', true)
                ->whereNotIn('id', $excludeIds);
            
            if ($categoryId) {
                // Correct relationship is 'category_id' column or 'category' belongsTo.
                // We don't have many-to-many highlights yet.
                $fillerQuery->where('category_id', $categoryId);
            }
            
            $fillers = $fillerQuery->latest()->limit($needed)->get();
            
            if ($highlights->count() + $fillers->count() < 3) {
                $stillNeeded = 3 - ($highlights->count() + $fillers->count());
                $globalFillers = Product::query()
                   ->select(['id', 'name', 'slug', 'image', 'price'])
                   ->where('is_active', true)
                   ->whereNotIn('id', array_merge($excludeIds, $fillers->pluck('id')->toArray()))
                   ->latest()
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
                'image_url' => $p->image_url,
                'price' => number_format((float)$p->price, 2, ',', '.')
            ];
        });

        return [
            'products' => $products,
            'categories' => []
        ];
    }

    private function searchActive(string $query, ?string $categorySlug = null): array
    {
        $productQuery = Product::query()
            ->select(['id', 'name', 'slug', 'image', 'price'])
            ->where('name', 'like', "%{$query}%")
            ->where('is_active', true);

        if ($categorySlug && $categorySlug !== 'Todos') {
            // Handle JSON string if passed
            if (str_starts_with($categorySlug, '{')) {
                try {
                   $obj = json_decode($categorySlug, true);
                   $categorySlug = $obj['slug'] ?? $categorySlug;
                } catch(\Exception $e) {}
            }
            
            $category = Category::where('slug', $categorySlug)->first(['id']);
            if ($category) {
                $productQuery->where('category_id', $category->id);
            }
        }

        $products = $productQuery->limit(5)->get();

        $formattedProducts = $products->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'image_url' => $p->image_url,
                'price' => number_format((float)$p->price, 2, ',', '.')
            ];
        });

        $categories = Category::query()
            ->where('name', 'like', "%{$query}%")
            ->where('is_active', true)
            ->limit(3)
            ->get(['id', 'name', 'slug']);

        return [
            'products' => $formattedProducts,
            'categories' => $categories
        ];
    }
}
