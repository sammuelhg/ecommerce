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
        // Load product images
        $product->load('images');
        
        // Produtos relacionados (mesma categoria)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        // Buscar TODOS os produtos irmãos (mesmo modelo e tipo)
        $siblings = Product::where('product_model_id', $product->product_model_id)
            ->where('product_type_id', $product->product_type_id)
            ->where('is_active', true)
            ->get();

        // 1. Agrupar Cores (para o seletor de cores)
        // Cada cor deve ter um link para um produto representativo daquela cor
        $colorVariants = $siblings->whereNotNull('color')
            ->groupBy('color')
            ->map(function ($group) use ($product) {
                // Tenta encontrar o produto com o mesmo tamanho do atual, senão pega o primeiro
                $representative = $group->where('size', $product->size)->first() ?? $group->first();
                
                return [
                    'name' => $group->first()->color,
                    'hex' => \App\Helpers\ColorHelper::getHex($group->first()->color),
                    'stock' => $group->sum('stock'),
                    'slug' => $representative->slug, // Link para trocar de cor
                    'active' => $group->first()->color === $product->color
                ];
            })->values();

        // 2. Agrupar Tamanhos (para o seletor de tamanhos)
        // Mostrar apenas tamanhos disponíveis para a COR ATUAL
        $sizeVariants = $siblings->where('color', $product->color)
            ->whereNotNull('size')
            ->sortBy('size') // Pode precisar de ordenação personalizada para P, M, G
            ->map(function ($variant) use ($product) {
                return [
                    'name' => $variant->size,
                    'stock' => $variant->stock,
                    'slug' => $variant->slug, // Link para trocar de tamanho
                    'active' => $variant->size === $product->size
                ];
            })->values();

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
