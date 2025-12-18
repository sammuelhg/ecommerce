<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShopController;

// Redirect root to shop
Route::get('/', function () {
    return redirect()->route('shop.index');
});

// Loja routes (MVC)
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'newShop'])->name('shop.new'); // Com regras
Route::get('/loja', [App\Http\Controllers\ShopController::class, 'newShopSimple'])->name('shop.index'); // Sem regras, 1 col mobile
Route::get('/loja2', [App\Http\Controllers\ShopController::class, 'newShopB'])->name('shop.index_b'); // Com regras, 2 col mobile
Route::get('/loja/busca', [App\Http\Controllers\ShopController::class, 'search'])->name('shop.search');
Route::get('/loja/busca/sugestoes', [App\Http\Controllers\ShopController::class, 'suggestions'])->name('shop.search.suggestions');
Route::get('/loja/categoria/{category}', [App\Http\Controllers\ShopController::class, 'category'])->name('shop.category');
Route::get('/loja/categoria/{parent}/{category}', [App\Http\Controllers\ShopController::class, 'subcategory'])->name('shop.subcategory');
Route::get('/loja/produto/{product}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');

// Cart Routes
Route::post('/loja/carrinho/sync', [App\Http\Controllers\CartController::class, 'sync'])->name('cart.sync');
Route::get('/loja/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout.index');

// Stories API (Public)
Route::get('/api/stories', function () {
    $stories = \App\Domains\Content\Models\Story::where('is_active', true)
        ->where('expires_at', '>', now())
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($story) {
            return [
                'id' => $story->id,
                'title' => $story->title,
                'subtitle' => $story->subtitle,
                'image_path' => $story->image_path,
                'link_url' => $story->link_url,
                'time_ago' => $story->created_at->diffForHumans(),
            ];
        });
    
    return response()->json(['stories' => $stories]);
})->name('api.stories');


Route::middleware(['auth'])->group(function () {
    Route::get('/conta/perfil', \App\Livewire\Customer\Profile\Edit::class)->name('customer.account.profile.edit');
    Route::view('/meus-pedidos', 'user.orders')->name('user.orders');
    Route::view('/enderecos', 'user.addresses')->name('user.addresses');
    Route::view('/pagamentos', 'user.payments')->name('user.payments');

    Route::view('/notificacoes', 'user.notifications')->name('user.notifications');
    Route::view('/cupons', 'user.coupons')->name('user.coupons');
    Route::view('/indique-amigos', 'user.referrals')->name('user.referrals');
    Route::view('/presentes', 'user.gifts')->name('user.gifts');
    Route::view('/clube', 'user.club')->name('user.club');
});

Auth::routes();

// Social Login
Route::get('auth/{provider}/redirect', [App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('auth/{provider}/callback', [App\Http\Controllers\Auth\SocialLoginController::class, 'handleProviderCallback'])->name('social.callback');

// Logout (GET)
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout.get');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// Admin Routes are now loaded via App\Domains\Admin\Providers\AdminServiceProvider
// located in app/Domains/Admin/Routes/web.php

// Public Newsletter Routes
// Public Campaign Routes (Renamed from Newsletter)
Route::get('/campaign/v/{campaign}', [\App\Http\Controllers\NewsletterController::class, 'show'])->name('newsletter.show');
Route::get('/campaign/email/{email}', [\App\Http\Controllers\NewsletterController::class, 'preview'])->name('newsletter.email.preview');
Route::get('/campaign/unsubscribe/{subscriber}', [\App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe')->middleware('signed');
Route::post('/campaign/resubscribe/{subscriber}', [\App\Http\Controllers\NewsletterController::class, 'resubscribe'])->name('newsletter.resubscribe');






// Email Logs & Test Routes (Local Only)
if (app()->isLocal()) {
    // Route::get('/test-email', ...); // Kept for local dev but commented out if needed, actually let's keep it in "if local" block
    
    // Test Route for Highlights Email
    Route::get('/test-email', function (\Illuminate\Http\Request $request, \App\Actions\SendHighlightsEmailAction $action) {
        // ... (Logic kept for dev)
        return "Email Test Endpoint (Active only in Local)";
    });
}

// Standard Contact Form Route
Route::post('/contact', [App\Http\Controllers\Shop\ContactController::class, 'store'])->name('shop.contact.store');



/*
|--------------------------------------------------------------------------
| Rotas Públicas (High Performance)
|--------------------------------------------------------------------------
*/
// Rota de Rastreamento (Pixel transparente)
Route::get('/pixel/{id}', \App\Http\Controllers\Web\PixelController::class)->name('pixel.track');

Route::get('/', function () {
    return redirect()->route('shop.index'); // Redirect to existing shop index
});

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.orders');
})->middleware(['auth', 'verified']);

// Add route to force run seeder.
Route::get('/force-seed', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => 'DeployRecoverySeeder',
            '--force' => true
        ]);
        return 'Seeder executado com sucesso: <pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return 'Erro: ' . $e->getMessage();
    }
});


Route::get('/debug-logs', function () {
    $logFile = storage_path('logs/laravel.log');
    if (!file_exists($logFile)) {
        return "Log file not found.";
    }
    // Read last 100 lines
    $lines = file($logFile);
    $output = array_slice($lines, -100);
    return '<pre>' . implode('', $output) . '</pre>';
});


// Digital Card & Linktree
Route::get('/card', function () {
    return view('card');
})->name('card');

Route::get('/links', function () {
    return view('links');
})->name('links');

// Landing Pages (Legacy)
Route::view('/minha-historia', 'landing.history')->name('landing.history');

// CMS Pages (New)
Route::get('/pages/{page}', [App\Http\Controllers\Cms\PageController::class, 'show'])->name('cms.page');

// Email Tracking Route
Route::get('/t/{campaign}/{lead}/pixel.gif', App\Http\Controllers\Tracking\TrackOpenController::class)->name('tracking.open');

// API Routes
Route::post('/api/leads', [App\Http\Controllers\LeadCaptureController::class, 'store'])->name('api.leads.store');

// Debug SMTP Route (Robust)
// Route::get('/debug/smtp', [App\Http\Controllers\SmtpDebugController::class, 'index']);

// Debug SMTP Route (Temporary - Deprecated)
// Route::get('/debug-smtp-legacy', ...);

// require __DIR__.'/test_web.php';
