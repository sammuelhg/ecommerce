<?php

declare(strict_types=1);

namespace App\Services\Shop;

use App\DTOs\Shop\ProductFilterDTO;
use App\Models\Product;
use App\Models\Category;
use App\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductService extends BaseService
{
    public function listProducts(ProductFilterDTO $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with(['images', 'category'])
            ->where('is_active', true);

        // Filter by Search
        if ($filters->search) {
            $query->where(function (Builder $q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters->search}%");
                //  ->orWhere('description', 'LIKE', "%{$filters->search}%"); // Disabled for performance
            });
        }

        // Filter by Category Slug (if provided)
        if ($filters->categorySlug) {
            $category = Category::where('slug', $filters->categorySlug)->first();
            if ($category) {
                 $ids = $category->children()->pluck('id')->push($category->id);
                 $query->whereIn('category_id', $ids);
            }
        }
        
        // Filter by Category IDs (direct override)
        if (!empty($filters->categoryIds)) {
            $query->whereIn('category_id', $filters->categoryIds);
        }

        // Filter by Price
        if ($filters->minPrice !== null) {
            $query->where('price', '>=', $filters->minPrice);
        }
        
        if ($filters->maxPrice !== null) {
            $query->where('price', '<=', $filters->maxPrice);
        }

        // Sort
        match ($filters->sortOrder) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->orderBy('created_at', 'desc'), // newest
        };

        return $query->paginate($perPage);
    }

    public function getActiveCategories(): Collection
    {
        return Category::where('is_active', true)->get();
    }

    public function getProductDetails(Product $product): array
    {
        // Load relationships
        $product->load(['images', 'productColor', 'productSize']);
        
        // Related Products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        // Siblings logic
        $siblings = Product::where('product_model_id', $product->product_model_id)
            ->where('product_type_id', $product->product_type_id)
            ->where('is_active', true)
            ->with(['productColor', 'productSize'])
            ->get();

        return [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'colorVariants' => $this->groupColorVariants($siblings, $product),
            'sizeVariants' => $this->groupSizeVariants($siblings, $product)
        ];
    }
    
    private function groupColorVariants(Collection $siblings, Product $mainProduct): Collection
    {
        $colorVariants = $siblings->groupBy(function($item) {
            return $item->product_color_id ?? $item->color ?? 'default';
        })->map(function ($group) use ($mainProduct) {
            $first = $group->first();
            $name = $first->productColor->name ?? $first->color;
            $hex = $first->productColor->hex_code ?? ($name ? \App\Helpers\ColorHelper::getHex($name) : '#cccccc');
            
            $representative = $group->filter(function($item) use ($mainProduct) {
                $itemSize = $item->productSize->name ?? $item->size;
                $currentSize = $mainProduct->productSize->name ?? $mainProduct->size;
                return $itemSize == $currentSize;
            })->first() ?? $group->first();

            $isActive = false;
            if ($mainProduct->product_color_id && $first->product_color_id) {
                $isActive = $mainProduct->product_color_id == $first->product_color_id;
            } else {
                $isActive = $mainProduct->color == $first->color;
            }

            if ($name) {
                return [
                    'name' => $name,
                    'hex' => $hex,
                    'stock' => $group->sum('stock'),
                    'slug' => $representative->slug, 
                    'active' => $isActive
                ];
            }
            return null;
        })->filter()->values();

        if ($colorVariants->isEmpty() && $mainProduct->color) {
            return collect([[
                'name' => $mainProduct->color,
                'hex' => \App\Helpers\ColorHelper::getHex($mainProduct->color),
                'stock' => $mainProduct->stock,
                'slug' => $mainProduct->slug,
                'active' => true
            ]]);
        }
        
        return $colorVariants;
    }

    private function groupSizeVariants(Collection $siblings, Product $mainProduct): Collection
    {
        $currentSiblings = $siblings->filter(function($item) use ($mainProduct) {
            if ($mainProduct->product_color_id && $item->product_color_id) {
                return $mainProduct->product_color_id == $item->product_color_id;
            }
            return $mainProduct->color == $item->color;
        });

        $sizeVariants = $currentSiblings->groupBy(function($item) {
            return $item->productSize->name ?? $item->size ?? 'default';
        })->map(function ($group) use ($mainProduct) {
            $first = $group->first();
            $name = $first->productSize->name ?? $first->size;
            
            if ($name) {
                $isActive = $group->contains(function($item) use ($mainProduct) {
                    return $item->id == $mainProduct->id;
                });
                
                return [
                    'name' => $name,
                    'stock' => $first->stock,
                    'slug' => $first->slug,
                    'active' => $isActive
                ];
            }
            return null;
        })->filter()->values();
        
        if ($sizeVariants->isEmpty() && $mainProduct->size) {
            return collect([[
                'name' => $mainProduct->size,
                'stock' => $mainProduct->stock,
                'slug' => $mainProduct->slug,
                'active' => true
            ]]);
        }

        return $sizeVariants;
    }

    public function productsToJson(Collection $products): string
    {
        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->price,
                'image' => $product->image,
                'imageText' => $product->image ?? 'Produto',
                'isOffer' => (bool) $product->is_offer,
                'oldPrice' => $product->old_price ? (float) $product->old_price : null,
                'category' => $product->category?->name ?? 'Geral'
            ];
        })->toJson();
    }
}
