<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure pagination to use Bootstrap 5
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        // Register Event Listeners
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\LeadCaptured::class,
            \App\Listeners\AttachLeadToCampaign::class
        );
        
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\OrderPaid::class,
            \App\Listeners\EvaluateFunnelRules::class
        );
        
        // Share settings with all views
        // Share settings with all views - Optimized
        // Using a closure for lazy loading, but target specific layouts to avoid overhead
        view()->composer(['layouts.admin', 'layouts.app', 'shop.*', 'livewire.*'], function ($view) {
            static $settings;

            if ($settings === null) {
                try {
                    // Direct DB fetch to avoid Cache locking issues on Windows/File driver
                    // Also reduced memory usage by not caching the entire collection structure if it's large
                    $settings = \App\Models\StoreSetting::all()->mapWithKeys(function ($item) {
                           return [$item->key => $item->value];
                    });
                } catch (\Throwable $e) {
                    $settings = collect();
                }
            }
            
            $view->with('storeSettings', $settings);
        });

        // Story Status Composer
        view()->composer(['shop.partials.header', 'shop.partials.user-offcanvas'], function ($view) {
            $service = app(\App\Services\Story\CheckUserStoriesService::class);
            $userId = \Illuminate\Support\Facades\Auth::id();
            $view->with('storyStatus', $service->handle($userId));
        });
    }
}
