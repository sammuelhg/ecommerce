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
    Route::view('/flavors', 'admin.flavors.index')->name('flavors.index');

    // Users
    Route::view('/users', 'admin.users.index')->name('users.index');

    // Store Settings
    Route::get('/settings/{tab?}', [App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\StoreSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/remove-certificate', [App\Http\Controllers\Admin\StoreSettingController::class, 'removeCertificate'])->name('settings.remove-certificate');
    
    // Email Previews
    // Link to Preview Dashboard (Handled below)
    Route::get('/emails/preview', [App\Http\Controllers\Admin\EmailPreviewController::class, 'index'])->name('emails.preview.dashboard');
    Route::get('/emails/preview/{type}', [App\Http\Controllers\Admin\EmailPreviewController::class, 'previewType'])->name('emails.preview.type');

    
    // Email Cards
    Route::view('/email-cards', 'admin.email-cards.index')->name('email-cards.index');
    
    // Links Bio
    Route::view('/links', 'admin.links.index')->name('links.index');
    
    // Integrações
    Route::view('/integrations', 'admin.integrations.index')->name('integrations.index');
    
    // Grid Manager
    Route::get('/grid', \App\Livewire\Admin\Grid\GridManager::class)->name('grid.index');
    // Route::get('/grid', \App\Livewire\Admin\Grid\GridManager::class)->name('grid.index'); // Replaced by Livewire route below

    // Newsletter Campaign Manager
    Route::prefix('newsletter')->name('newsletter.')->group(function () {
        // Dashboard Stats
        Route::get('/', \App\Livewire\Admin\Newsletter\NewsletterDashboard::class)->name('dashboard');
        // Subscribers Manager
        Route::get('/subscribers', \App\Livewire\Admin\Newsletter\SubscriberManager::class)->name('subscribers');
        // Campaign Manager
        Route::get('/templates', \App\Livewire\Admin\Newsletter\TemplateManager::class)->name('templates');
        Route::get('/campaigns', \App\Livewire\Admin\Newsletter\CampaignManager::class)->name('campaigns');
        Route::get('/campaigns/{campaign}/builder', \App\Livewire\Admin\Newsletter\CampaignBuilder::class)->name('campaign.builder');
        // Contacts
        Route::get('/contacts', \App\Livewire\Admin\Newsletter\ContactManager::class)->name('contacts');
    });

    // Marketing
    Route::get('/grid', App\Livewire\Admin\Grid\GridManager::class)->name('grid.index');
    Route::get('/marketing/search', App\Livewire\Admin\Marketing\SearchHighlights::class)->name('marketing.search');

    // Leads
    Route::get('/leads', App\Livewire\Admin\Leads\LeadManager::class)->name('leads.index');

    // CRM / Unified Audience
    Route::prefix('crm')->name('crm.')->group(function() {
        Route::get('/audience', \App\Livewire\Admin\Crm\AudienceIndex::class)->name('audience');
        
        Route::get('/traffic/organic', function() {
            return view('admin.crm.placeholder', ['title' => 'Tráfego Orgânico', 'feature' => 'Análise de Tráfego Orgânico']);
        })->name('organic-traffic');

        Route::get('/traffic/paid', \App\Livewire\Admin\Crm\ExpenseManager::class)->name('paid-traffic');

        Route::get('/reports', \App\Livewire\Admin\Crm\FinancialReport::class)->name('reports');

        Route::get('/forms/builder', \App\Livewire\Forms\FormBuilder::class)->name('forms.builder');
    });

    // Stories (History)
    Route::resource('stories', App\Http\Controllers\Admin\StoryController::class)->only(['index', 'store', 'update']);
    Route::delete('/stories/{id}', [App\Http\Controllers\Admin\StoryController::class, 'destroy'])->name('stories.destroy');
    Route::patch('/stories/{id}/toggle', [App\Http\Controllers\Admin\StoryController::class, 'toggleStatus'])->name('stories.toggle');
});

// Public Newsletter Routes
Route::get('/newsletter/c/{campaign}', [\App\Http\Controllers\NewsletterController::class, 'show'])->name('newsletter.show');
Route::get('/newsletter/e/{email}', [\App\Http\Controllers\NewsletterController::class, 'preview'])->name('newsletter.email.preview');
Route::get('/newsletter/unsubscribe/{subscriber}', [\App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe')->middleware('signed');
Route::post('/newsletter/resubscribe/{subscriber}', [\App\Http\Controllers\NewsletterController::class, 'resubscribe'])->name('newsletter.resubscribe');



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

// Email Logs & Test Routes (Local Only)
if (app()->isLocal()) {


    // Test Route for Highlights Email
    Route::get('/test-email', function (\Illuminate\Http\Request $request, \App\Actions\SendHighlightsEmailAction $action) {
        $dto = new \App\DTOs\HighlightsDTO(
            title: 'Novidades da Semana',
            subtitle: 'Confira as peças que acabaram de chegar e estão bombando na LosFit!',
            imageUrl: 'https://images.unsplash.com/photo-1518310383802-640c2de311b2?w=500&auto=format&fit=crop&q=60', // Dummy Image
            ctaText: 'Ver Coleção',
            ctaUrl: url('/shop'),
            items: [
                ['name' => 'Top Fitness', 'price' => 'R$ 89,90', 'url' => '#', 'image' => 'https://via.placeholder.com/60'],
                ['name' => 'Legging Pro', 'price' => 'R$ 129,90', 'url' => '#', 'image' => 'https://via.placeholder.com/60']
            ]
        );

        // Get email from ?email=param or default to system admin
        $email = $request->query('email', 'admin@losfit.com.br');
        
        try {
            $action->execute($email, $dto);
            return "Email de Destaques enviado com sucesso para: <strong>$email</strong>! <br>Verifique sua caixa de entrada (e Spam).";
        } catch (\Exception $e) {
            return "Erro ao enviar email: " . $e->getMessage();
        }
    });
}

// Standard Contact Form Route
Route::post('/contact', [App\Http\Controllers\Shop\ContactController::class, 'store'])->name('shop.contact.store');

Route::get('/test-buttons', function () {
    return view('test-buttons');
});

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

Route::get('/admin/dashboard', \App\Livewire\Admin\Dashboard::class)
    ->middleware(['auth'])
    ->name('admin.dashboard');

// Digital Card & Linktree
Route::get('/card', function () {
    return view('card');
})->name('card');

Route::get('/links', function () {
    return view('links');
})->name('links');

// Landing Pages
Route::view('/minha-historia', 'landing.history')->name('landing.history');

// Email Tracking Route
Route::get('/t/{campaign}/{lead}/pixel.gif', App\Http\Controllers\Tracking\TrackOpenController::class)->name('tracking.open');

// API Routes
Route::post('/api/leads', [App\Http\Controllers\LeadCaptureController::class, 'store'])->name('api.leads.store');

// Debug SMTP Route (Temporary)
Route::get('/debug-smtp', function () {
    $key = 'smtp_host';
    $testValue = 'test.smtp.server.com';
    
    // 1. Check current value
    $current = \App\Models\StoreSetting::where('key', $key)->first();
    echo "Current Value in DB: " . ($current ? $current->value : 'NOT FOUND') . "<br>";
    
    // 2. Try simple update
    try {
        \App\Models\StoreSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $testValue, 'type' => 'text']
        );
        echo "Update executed.<br>";
    } catch (\Exception $e) {
        echo "Update FAILED: " . $e->getMessage() . "<br>";
    }
    
    // 3. Check again
    $after = \App\Models\StoreSetting::where('key', $key)->first();
    echo "Value After Update: " . ($after ? $after->value : 'NOT FOUND') . "<br>";
    
    echo "<br>Dump of all settings:<br>";
    dump(\App\Models\StoreSetting::all()->toArray());
});
