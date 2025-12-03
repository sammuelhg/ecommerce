<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShopController;

// Redirect root to shop
Route::get('/', function () {
    return redirect()->route('shop.index');
});

// Loja routes (MVC)
Route::get('/loja', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/loja/busca', [App\Http\Controllers\ShopController::class, 'search'])->name('shop.search');
Route::get('/loja/categoria/{category}', [App\Http\Controllers\ShopController::class, 'category'])->name('shop.category');
Route::get('/loja/categoria/{parent}/{category}', [App\Http\Controllers\ShopController::class, 'subcategory'])->name('shop.subcategory');
Route::get('/loja/produto/{product}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');

// Cart Routes
Route::post('/loja/carrinho/sync', [App\Http\Controllers\CartController::class, 'sync'])->name('cart.sync');
Route::get('/loja/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', App\Livewire\UserProfile::class)->name('profile');
    Route::view('/meus-pedidos', 'user.orders')->name('user.orders');
    Route::view('/enderecos', 'user.addresses')->name('user.addresses');
    Route::view('/pagamentos', 'user.payments')->name('user.payments');
    Route::view('/configuracoes', 'user.settings')->name('user.settings');
});

Auth::routes();

// Social Login
Route::get('auth/{provider}/redirect', [App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('auth/{provider}/callback', [App\Http\Controllers\Auth\SocialLoginController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::view('/products', 'admin.products.index')->name('products.index');
    Route::view('/products/create', 'admin.products.create')->name('products.create');
    Route::get('/products/{product}', function ($product) {
        // Try to find by ID first, then by slug
        $productModel = is_numeric($product) 
            ? \App\Models\Product::findOrFail($product)
            : \App\Models\Product::where('slug', $product)->firstOrFail();
        
        return view('admin.products.edit', ['product' => $productModel]);
    })->name('products.edit');
    Route::view('/categories', 'admin.categories.index')->name('categories.index');
    Route::view('/orders', 'admin.orders.index')->name('orders.index');
    
    // Product Attributes
    Route::view('/types', 'admin.types.index')->name('types.index');
    Route::view('/materials', 'admin.materials.index')->name('materials.index');
    Route::view('/models', 'admin.models.index')->name('models.index');
    Route::view('/colors', 'admin.colors.index')->name('colors.index');
    Route::view('/sizes', 'admin.sizes.index')->name('sizes.index');

    // Users
    Route::view('/users', 'admin.users.index')->name('users.index');

    // Store Settings
    Route::get('/settings', [App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\StoreSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/remove-certificate', [App\Http\Controllers\Admin\StoreSettingController::class, 'removeCertificate'])->name('settings.remove-certificate');
});


Route::get('/teste-main', function () {
    $dbProducts = App\Models\Product::all();
    
    $productsJson = $dbProducts->isEmpty() 
        ? json_encode([]) 
        : $dbProducts->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'price' => (float) $p->price,
            'imageText' => $p->image,
            'isOffer' => (bool) $p->is_offer,
            'oldPrice' => $p->old_price ? (float) $p->old_price : null,
        ])->toJson();
    
    return view('shop', compact('productsJson'));
})->name('shop.test');

Route::get('/test-livewire', function () {
    return view('test_livewire');
});
