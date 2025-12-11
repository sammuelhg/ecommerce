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
    public function suggestions(Request $request, \App\Actions\Shop\GetSearchSuggestionsAction $action): \Illuminate\Http\JsonResponse
    {
        $query = $request->input('q');
        $categorySlug = $request->input('category');
        
        $data = $action->execute($query, $categorySlug);

        return response()->json($data);
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
