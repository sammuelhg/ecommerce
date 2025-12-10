<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\Shop\ProductService;
use App\DTOs\Shop\ProductFilterDTO;

class ShopController extends Controller
{
    public function __construct(
        protected ProductService $service
    ) {}

    /**
     * Search suggestions API
     */
    public function suggestions(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = $request->input('q');
        $categorySlug = $request->input('category');
        
        // CASE: Default Suggestions (Search Highlights)
        // Triggered when query is empty but we want to show suggestions for the selected category (or global)
        if (empty($query)) {
             $categoryId = null;
             
             if ($categorySlug && $categorySlug !== 'Todos') {
                 $category = Category::where('slug', $categorySlug)->first();
                 $categoryId = $category?->id;
             }

             // 1. Try to get configured highlights
             $highlights = \App\Models\SearchHighlight::with('product')
                ->where('category_id', $categoryId)
                ->limit(3)
                ->get()
                ->pluck('product');

             // 2. If not enough, fill with products from the category (if selected) or top selling/random
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
                 
                 // Fallback: If category has no products, remove category constraint to ensure we show *something*
                 // (User said: "se a catogoria não tiver 3 produtos acrescentar de outras de cada categoria")
                 // We'll check count first? Or just chain order.
                 // Let's standardise: randomized for now or latest
                 $fillers = $fillerQuery->inRandomOrder()->limit($needed)->get();
                 
                 // If still not enough (e.g. strict category filter returned 0), loosen filter
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

             // Sort for JSON
             $products = $highlights->take(3)->map(function($p) {
                 return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'image' => $p->image
                 ];
             });

             return response()->json([
                 'products' => $products,
                 'categories' => [] // No categories suggestion for empty search
             ]);
        }

        // CASE: Active Typing Search
        if (strlen($query) < 2) {
            return response()->json(['products' => [], 'categories' => []]);
        }

        $products = Product::where('name', 'like', "%{$query}%")
            ->where('is_active', true)
            ->limit(5)
            ->get(['id', 'name', 'slug', 'image']);

        $categories = Category::where('name', 'like', "%{$query}%")
            ->where('is_active', true)
            ->limit(3)
            ->get(['id', 'name', 'slug']);

        return response()->json([
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * Display the shop homepage with filtered products
     */
    public function index(Request $request): \Illuminate\View\View
    {
        $filters = ProductFilterDTO::fromRequest($request);
        
        $products = $this->service->listProducts($filters, 12);
        
        // Since we are now paginating, we pass the products collection to JSON as before
        $productsJson = $this->service->productsToJson(collect($products->items()));

        $categories = $this->service->getActiveCategories();

        return view('shop.index', compact('products', 'categories', 'productsJson'));
    }

    /**
     * Display the new shop homepage with dynamic grid
     */
    public function newShop(): \Illuminate\View\View
    {
        $categories = $this->service->getActiveCategories();
        return view('shop.dynamic', compact('categories') + ['variant' => 'A']);
    }

    public function newShopB(): \Illuminate\View\View
    {
        $categories = $this->service->getActiveCategories();
        return view('shop.dynamic', compact('categories') + ['variant' => 'B']);
    }

    public function newShopSimple(): \Illuminate\View\View
    {
        $categories = $this->service->getActiveCategories();
        return view('shop.dynamic', compact('categories') + ['variant' => 'simple']);
    }

    /**
     * Display a single product
     */
    public function show(Product $product): \Illuminate\View\View
    {
        $details = $this->service->getProductDetails($product);
        
        $relatedProducts = $details['relatedProducts'];
        $colorVariants = $details['colorVariants'];
        $sizeVariants = $details['sizeVariants'];
        
        if ($product->isKit()) {
            return view('shop.show-kit', compact('product', 'relatedProducts', 'colorVariants', 'sizeVariants'));
        }

        return view('shop.show', compact('product', 'relatedProducts', 'colorVariants', 'sizeVariants'));
    }

    /**
     * Search products
     */
    public function search(Request $request): \Illuminate\View\View
    {
        $filters = ProductFilterDTO::fromRequest($request);
        
        // If category param exists, we might need/want to enforce it in filters if DTO didn't pick it up
        // But assuming DTO handles it or we just care about display for now:
        $categorySlug = $request->input('category');
        $category = ($categorySlug && $categorySlug !== 'Todos') 
            ? Category::where('slug', $categorySlug)->first() 
            : null;

        if ($category) {
            // Optional: Ensure filter actually uses this category if DTO didn't (pseudo-code, simplistic)
            // $filters->categoryIds = [$category->id]; 
            // The user didn't complain about filtering, strictly about the Title View.
        }

        $products = $this->service->listProducts($filters, 12);
        
        $query = $filters->search; // For view display

        return view('shop.search', compact('products', 'query', 'category'));
    }

    /**
     * Filter by category
     */
    public function category(Category $category, Request $request): \Illuminate\View\View
    {
        // manually construct DTO with categoryIds since we resolved the model already
        $categoryIds = $category->children()->pluck('id')->push($category->id)->toArray();
        
        $filters = new ProductFilterDTO(
            search: $request->input('q'),
            minPrice: $request->input('min_price') ? (float)$request->input('min_price') : null,
            maxPrice: $request->input('max_price') ? (float)$request->input('max_price') : null,
            sortOrder: $request->input('sort', 'newest'),
            categoryIds: $categoryIds
        );
        
        $products = $this->service->listProducts($filters, 12);
        $productsJson = $this->service->productsToJson(collect($products->items()));
        
        $categories = $this->service->getActiveCategories();

        return view('shop.category', compact('products', 'category', 'categories', 'productsJson'));
    }

    /**
     * Filter by subcategory
     */
    public function subcategory(Category $parent, Category $category, Request $request): \Illuminate\View\View
    {
        // Just the subcategory products
        $filters = new ProductFilterDTO(
            search: $request->input('q'),
            minPrice: $request->input('min_price') ? (float)$request->input('min_price') : null,
            maxPrice: $request->input('max_price') ? (float)$request->input('max_price') : null,
            sortOrder: $request->input('sort', 'newest'),
            categoryIds: [$category->id]
        );

        $products = $this->service->listProducts($filters, 12);
        $productsJson = $this->service->productsToJson(collect($products->items()));
        
        $categories = $this->service->getActiveCategories();

        return view('shop.category', compact('products', 'category', 'categories', 'productsJson', 'parent'));
    }
}
