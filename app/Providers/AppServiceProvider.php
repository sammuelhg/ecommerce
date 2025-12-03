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
        
        // Share settings with all views
        view()->composer('*', function ($view) {
            // Cache settings for performance if needed, but for now direct query
            // Check if table exists to avoid errors during migration
            if (\Schema::hasTable('store_settings')) {
                $settings = \App\Models\StoreSetting::all()->pluck('value', 'key');
                $view->with('storeSettings', $settings);
            }
        });
    }
}
