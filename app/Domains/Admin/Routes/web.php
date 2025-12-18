<?php

use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
Route::get('/forms/new', \App\Livewire\Forms\FormBuilder::class)->name('forms.create');

// Products
Route::view('/products', 'admin.products.index')->name('products.index');
Route::view('/products/create', 'admin.products.create')->name('products.create');
Route::get('/products/{product}', function ($product) {
    // Try to find by ID first, then by slug
    $productModel = is_numeric($product) 
        ? \App\Domains\Catalog\Models\Product::findOrFail($product)
        : \App\Domains\Catalog\Models\Product::where('slug', $product)->firstOrFail();
    
    return view('admin.products.edit', ['product' => $productModel]);
})->name('products.edit');

// Categories & Orders
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
Route::get('/settings/{tab?}', [\App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [\App\Http\Controllers\Admin\StoreSettingController::class, 'update'])->name('settings.update');
Route::post('/settings/reset-prompts', [\App\Http\Controllers\Admin\StoreSettingController::class, 'resetAiPrompts'])->name('settings.reset-prompts');
Route::post('/settings/remove-certificate', [\App\Http\Controllers\Admin\StoreSettingController::class, 'removeCertificate'])->name('settings.remove-certificate');
Route::get('/settings/team', [\App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.team'); 
Route::get('/settings/billing', [\App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.billing'); 

// Email Previews
Route::get('/emails/preview', [\App\Http\Controllers\Admin\EmailPreviewController::class, 'index'])->name('emails.preview.dashboard');
Route::get('/emails/preview/{type}', [\App\Http\Controllers\Admin\EmailPreviewController::class, 'previewType'])->name('emails.preview.type');

// Links Bio
Route::view('/links', 'admin.links.index')->name('links.index');

// Integrações
Route::view('/integrations', 'admin.integrations.index')->name('integrations.index');

// Sign Card Manager
Route::get('/sign-cards', \App\Livewire\Admin\SignCard\SignCardManager::class)->name('sign-cards');

// Funnel Intelligence
Route::get('/funnel', \App\Livewire\Admin\Leads\LeadKanban::class)->name('funnel.index');
Route::get('/funnel/automations', \App\Livewire\Admin\Funnel\FunnelAutomationManager::class)->name('funnel.automations');

// Newsletter/Campaigns Legacy & Unified
Route::prefix('marketing')->name('marketing.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Marketing\MarketingDashboard::class)->name('dashboard');
    Route::get('/report/{campaign}', \App\Livewire\Admin\Marketing\CampaignReport::class)->name('report');
    Route::get('/contacts', \App\Livewire\Admin\Newsletter\ContactManager::class)->name('contacts');
});

// New Campaign Domain
Route::prefix('campaigns')->name('campaigns.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Campaign\CampaignIndex::class)->name('index');
     Route::get('/builder/{campaign?}', \App\Livewire\Admin\Campaign\CampaignBuilder::class)->name('builder');
    Route::get('/identities', \App\Livewire\Admin\SignCard\SignCardManager::class)->name('identities');
});

// Marketing
Route::get('/grid', \App\Livewire\Admin\Grid\GridManager::class)->name('grid.index');
Route::get('/marketing/search', \App\Livewire\Admin\Marketing\SearchHighlights::class)->name('marketing.search');

// Leads
Route::get('/leads', \App\Livewire\Admin\Leads\LeadManager::class)->name('leads.index');
Route::get('/leads/kanban', \App\Livewire\Admin\Leads\LeadKanban::class)->name('leads.kanban');

// CRM / Unified Audience
Route::prefix('crm')->name('crm.')->group(function() {
    Route::get('/audience', \App\Livewire\Admin\Crm\AudienceIndex::class)->name('audience');
    
    Route::get('/traffic/organic', function() {
        return view('admin.crm.placeholder', ['title' => 'Tráfego Orgânico', 'feature' => 'Análise de Tráfego Orgânico']);
    })->name('organic-traffic');

    Route::get('/traffic/paid', \App\Livewire\Admin\Crm\ExpenseManager::class)->name('paid-traffic');
    
    Route::get('/expenses/general', \App\Livewire\Admin\Crm\ExpenseManager::class)
        ->defaults('fixedSource', 'other')
        ->name('expenses.general');

    Route::get('/reports', \App\Livewire\Admin\Crm\FinancialReport::class)->name('reports');

    Route::get('/forms/builder', \App\Livewire\Forms\FormBuilder::class)->name('forms.builder');
});

// CMS / Page Builder
Route::prefix('cms')->name('cms.')->group(function () {
    Route::get('/pages', \App\Livewire\Cms\PageIndex::class)->name('pages.index');
    Route::get('/pages/builder/{pageIdentifier?}', \App\Livewire\Cms\PageBuilder::class)->name('pages.builder');
    
    Route::get('/components', \App\Livewire\Cms\ComponentIndex::class)->name('components.index');
    Route::get('/components/builder/{component?}', \App\Livewire\Cms\ComponentBuilder::class)->name('components.builder');
});

// Stories (History)
Route::resource('stories', \App\Http\Controllers\Admin\StoryController::class)->only(['index', 'store', 'update']);
Route::delete('/stories/{id}', [\App\Http\Controllers\Admin\StoryController::class, 'destroy'])->name('stories.destroy');
Route::patch('/stories/{id}/toggle', [\App\Http\Controllers\Admin\StoryController::class, 'toggleStatus'])->name('stories.toggle');
