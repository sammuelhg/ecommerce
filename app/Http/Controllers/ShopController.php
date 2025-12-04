<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the shop homepage with all products
     */
    public function index()
    {
        // Busca todos os produtos ativos
        $products = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Busca categorias ativas
        $categories = Category::where('is_active', true)
            ->get();

        // Prepara produtos para JSON (Alpine.js)
        $productsJson = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'imageText' => $product->image ?? 'Produto',
                'isOffer' => (bool) $product->is_offer,
                'oldPrice' => $product->old_price ? (float) $product->old_price : null,
                'stock' => $product->stock,
                'category' => $product->category?->name ?? 'Geral'
            ];
        })->toJson();

        return view('shop.index', compact('products', 'categories', 'productsJson'));
    }

    /**
     * Display a single product
     */
    public function show(Product $product)
    {
        // Load product images, color and size relationships
        $product->load(['images', 'productColor', 'productSize']);
        
        // Produtos relacionados (mesma categoria)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        // Buscar TODOS os produtos irmãos (mesmo modelo e tipo)
        // Usando product_model_id como agrupador principal
        $siblings = Product::where('product_model_id', $product->product_model_id)
            ->where('product_type_id', $product->product_type_id)
            ->where('is_active', true)
            ->with(['productColor', 'productSize'])
            ->get();

        // 1. Agrupar Cores (para o seletor de cores)
        $colorVariants = $siblings->groupBy(function($item) {
            // Agrupa por ID da cor ou string da cor
            return $item->product_color_id ?? $item->color ?? 'default';
        })->map(function ($group) use ($product) {
            $first = $group->first();
            
            // Determina nome e hex
            $name = $first->productColor->name ?? $first->color;
            $hex = $first->productColor->hex_code ?? ($name ? \App\Helpers\ColorHelper::getHex($name) : '#cccccc');
            
            // Tenta encontrar o produto representante desta cor que tenha o mesmo tamanho do produto atual
            // Se não achar, pega o primeiro da lista
            $representative = $group->filter(function($item) use ($product) {
                $itemSize = $item->productSize->name ?? $item->size;
                $currentSize = $product->productSize->name ?? $product->size;
                return $itemSize == $currentSize;
            })->first() ?? $group->first();

            // Verifica se é a cor ativa
            $isActive = false;
            if ($product->product_color_id && $first->product_color_id) {
                $isActive = $product->product_color_id == $first->product_color_id;
            } else {
                $isActive = $product->color == $first->color;
            }

            if ($name) {
                return [
                    'name' => $name,
                    'hex' => $hex,
                    'stock' => $group->sum('stock'), // Total de estoque dessa cor (todos os tamanhos)
                    'slug' => $representative->slug, 
                    'active' => $isActive
                ];
            }
            return null;
        })->filter()->values();

        // 2. Agrupar Tamanhos (para o seletor de tamanhos)
        // Filtra siblings para mostrar apenas tamanhos da COR ATUAL
        $currentSiblings = $siblings->filter(function($item) use ($product) {
            if ($product->product_color_id && $item->product_color_id) {
                return $product->product_color_id == $item->product_color_id;
            }
            return $product->color == $item->color;
        });

        $sizeVariants = $currentSiblings->groupBy(function($item) {
            // Agrupa por nome do tamanho
            return $item->productSize->name ?? $item->size ?? 'default';
        })->map(function ($group) use ($product) {
            $first = $group->first();
            $name = $first->productSize->name ?? $first->size;
            
            if ($name) {
                // Verifica se algum deste grupo é o produto atual
                $isActive = $group->contains(function($item) use ($product) {
                    return $item->id == $product->id;
                });
                
                return [
                    'name' => $name,
                    'stock' => $first->stock, // Stock do produto representante (não soma)
                    'slug' => $first->slug,
                    'active' => $isActive
                ];
            }
            return null;
        })->filter()->values();

        // Fallback se não houver variações (produto único)
        if ($colorVariants->isEmpty() && $product->color) {
            $colorVariants = collect([[
                'name' => $product->color,
                'hex' => \App\Helpers\ColorHelper::getHex($product->color),
                'stock' => $product->stock,
                'slug' => $product->slug,
                'active' => true
            ]]);
        }

        if ($sizeVariants->isEmpty() && $product->size) {
            $sizeVariants = collect([[
                'name' => $product->size,
                'stock' => $product->stock,
                'slug' => $product->slug,
                'active' => true
            ]]);
        }

        if ($product->isKit()) {
            return view('shop.show-kit', compact('product', 'relatedProducts', 'colorVariants', 'sizeVariants'));
        }

        return view('shop.show', compact('product', 'relatedProducts', 'colorVariants', 'sizeVariants'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->get();

        return view('shop.search', compact('products', 'query'));
    }

    /**
     * Filter by category
     */
    public function category(Category $category)
    {
        // Get all category IDs (current + children)
        $categoryIds = $category->children()->pluck('id')->push($category->id);

        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->get();

        $categories = Category::where('is_active', true)->get();

        $productsJson = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'imageText' => $product->image ?? 'Produto',
                'isOffer' => (bool) $product->is_offer,
                'oldPrice' => $product->old_price ? (float) $product->old_price : null,
            ];
        })->toJson();

        return view('shop.category', compact('products', 'category', 'categories', 'productsJson'));
    }

    /**
     * Filter by subcategory
     */
    public function subcategory(Category $parent, Category $category)
    {
        $products = $category->products()
            ->where('is_active', true)
            ->get();

        $categories = Category::where('is_active', true)->get();

        $productsJson = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'imageText' => $product->image ?? 'Produto',
                'isOffer' => (bool) $product->is_offer,
                'oldPrice' => $product->old_price ? (float) $product->old_price : null,
            ];
        })->toJson();

        return view('shop.category', compact('products', 'category', 'categories', 'productsJson', 'parent'));
    }
}
