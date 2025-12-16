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
    $stories = \App\Models\Story::where('is_active', true)
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

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/forms/new', \App\Livewire\Forms\FormBuilder::class)->name('forms.create');
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
    Route::view('/flavors', 'admin.flavors.index')->name('flavors.index');

    // Users
    Route::view('/users', 'admin.users.index')->name('users.index');

    // Store Settings
    Route::get('/settings/{tab?}', [App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\StoreSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset-prompts', [App\Http\Controllers\Admin\StoreSettingController::class, 'resetAiPrompts'])->name('settings.reset-prompts');
    Route::post('/settings/remove-certificate', [App\Http\Controllers\Admin\StoreSettingController::class, 'removeCertificate'])->name('settings.remove-certificate');
    Route::get('/settings/team', [App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.team'); // Reuse index with 'team' tab logic if possible, or new method
    Route::get('/settings/billing', [App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.billing'); // Reuse index with 'billing' tab logic
    
    // Email Previews
    // Link to Preview Dashboard (Handled below)
    Route::get('/emails/preview', [App\Http\Controllers\Admin\EmailPreviewController::class, 'index'])->name('emails.preview.dashboard');
    Route::get('/emails/preview/{type}', [App\Http\Controllers\Admin\EmailPreviewController::class, 'previewType'])->name('emails.preview.type');

    
    // Email Cards
    // Route::view('/email-cards', 'admin.email-cards.index')->name('email-cards.index'); // Deprecated, use sign-cards
    
    // Links Bio
    Route::view('/links', 'admin.links.index')->name('links.index');
    
    // Integrações
    Route::view('/integrations', 'admin.integrations.index')->name('integrations.index');
    
    // Sign Card Manager
    Route::get('/sign-cards', \App\Livewire\Admin\SignCard\SignCardManager::class)->name('sign-cards');

    // Funnel Intelligence (Phase 11)
    Route::get('/funnel', \App\Livewire\Admin\Leads\LeadKanban::class)->name('funnel.index'); // User Request: "More Funnel Here"
    Route::get('/funnel/automations', \App\Livewire\Admin\Funnel\FunnelAutomationManager::class)->name('funnel.automations');
    // Route::get('/grid', \App\Livewire\Admin\Grid\GridManager::class)->name('grid.index'); // Replaced by Livewire route below

    // Newsletter/Campaigns Legacy & Unified
    Route::prefix('marketing')->name('marketing.')->group(function () {
        // Dashboard Stats
        Route::get('/', \App\Livewire\Admin\Newsletter\NewsletterDashboard::class)->name('dashboard');
        // Subscribers Manager
        Route::get('/contacts', \App\Livewire\Admin\Newsletter\ContactManager::class)->name('contacts');
    });

    // New Campaign Domain (Phase 2 Refactor)
    Route::prefix('campaigns')->name('campaigns.')->group(function () {
        Route::get('/', \App\Livewire\Admin\Campaign\CampaignIndex::class)->name('index');
         Route::get('/builder/{campaign?}', \App\Livewire\Admin\Campaign\CampaignBuilder::class)->name('builder');
        Route::get('/identities', \App\Livewire\Admin\SignCard\SignCardManager::class)->name('identities'); // Phase 4
    });

    // Marketing
    Route::get('/grid', App\Livewire\Admin\Grid\GridManager::class)->name('grid.index');
    Route::get('/marketing/search', App\Livewire\Admin\Marketing\SearchHighlights::class)->name('marketing.search');

    // Leads
    Route::get('/leads', App\Livewire\Admin\Leads\LeadManager::class)->name('leads.index');
    Route::get('/leads/kanban', \App\Livewire\Admin\Leads\LeadKanban::class)->name('leads.kanban');

    // CRM / Unified Audience
    Route::prefix('crm')->name('crm.')->group(function() {
        Route::get('/audience', \App\Livewire\Admin\Crm\AudienceIndex::class)->name('audience');
        
        Route::get('/traffic/organic', function() {
            return view('admin.crm.placeholder', ['title' => 'Tráfego Orgânico', 'feature' => 'Análise de Tráfego Orgânico']);
        })->name('organic-traffic');

        // Paid Traffic (Ads) - Uses ExpenseManager but we will eventually filter/tabulate it
        Route::get('/traffic/paid', \App\Livewire\Admin\Crm\ExpenseManager::class)->name('paid-traffic');
        
        // General Expenses (Other) - Fixed Source View
        Route::get('/expenses/general', \App\Livewire\Admin\Crm\ExpenseManager::class)
            ->defaults('fixedSource', 'other')
            ->name('expenses.general');

        Route::get('/reports', \App\Livewire\Admin\Crm\FinancialReport::class)->name('reports');

        Route::get('/forms/builder', \App\Livewire\Forms\FormBuilder::class)->name('forms.builder');
    });

    // CMS / Page Builder
    Route::prefix('cms')->name('cms.')->group(function () {
        // Pages
        Route::get('/pages', \App\Livewire\Cms\PageIndex::class)->name('pages.index');
        Route::get('/pages/builder/{page?}', \App\Livewire\Cms\PageBuilder::class)->name('pages.builder');
        
        // Components
        Route::get('/components', \App\Livewire\Cms\ComponentIndex::class)->name('components.index');
        Route::get('/components/builder/{component?}', \App\Livewire\Cms\ComponentBuilder::class)->name('components.builder');
    });

    // Stories (History)
    Route::resource('stories', App\Http\Controllers\Admin\StoryController::class)->only(['index', 'store', 'update']);
    Route::delete('/stories/{id}', [App\Http\Controllers\Admin\StoryController::class, 'destroy'])->name('stories.destroy');
    Route::patch('/stories/{id}/toggle', [App\Http\Controllers\Admin\StoryController::class, 'toggleStatus'])->name('stories.toggle');
});

// Public Newsletter Routes
// Public Campaign Routes (Renamed from Newsletter)
Route::get('/campaign/v/{campaign}', [\App\Http\Controllers\NewsletterController::class, 'show'])->name('newsletter.show');
Route::get('/campaign/email/{email}', [\App\Http\Controllers\NewsletterController::class, 'preview'])->name('newsletter.email.preview');
Route::get('/campaign/unsubscribe/{subscriber}', [\App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe')->middleware('signed');
Route::post('/campaign/resubscribe/{subscriber}', [\App\Http\Controllers\NewsletterController::class, 'resubscribe'])->name('newsletter.resubscribe');




// Route::get('/teste-main', function () {
//     $dbProducts = App\Models\Product::all();
//    
//     $productsJson = $dbProducts->isEmpty() 
//         ? json_encode([]) 
//         : $dbProducts->map(fn($p) => [
//             'id' => $p->id,
//             'name' => $p->name,
//             'price' => (float) $p->price,
//             'imageText' => $p->image,
//             'isOffer' => (bool) $p->is_offer,
//             'oldPrice' => $p->old_price ? (float) $p->old_price : null,
//         ])->toJson();
//    
//     return view('shop', compact('productsJson'));
// })->name('shop.test');

// Route::get('/test-livewire', function () {
//     return view('test_livewire');
// });

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

// Route::get('/test-buttons', function () {
//     return view('test-buttons');
// });

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
    return redirect()->route('admin.dashboard'); // Redirect to existing admin dashboard
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
