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
                $settings = \App\Models\StoreSetting::all()->mapWithKeys(function ($item) {
                     // Fix for localhost URLs in production dump (Handle standard and port 8000 and double port edge case)
                     $value = str_replace(
                        [
                            'http://localhost:8000/:8000', 'https://localhost:8000/:8000', // Double port edge case
                            'http://localhost:8000', 'https://localhost:8000', 
                            'http://localhost', 'https://localhost'
                        ], 
                        '', 
                        $item->value
                     );
                     return [$item->key => $value];
                });
                $view->with('storeSettings', $settings);
            }
        });

        // Story Status Composer
        view()->composer(['shop.partials.header', 'shop.partials.user-offcanvas'], function ($view) {
            $service = app(\App\Services\Story\CheckUserStoriesService::class);
            // Auth facade requires alias or full path if not imported. 
            // It is not imported in the file view, so using full path or helping helper.
            $userId = \Illuminate\Support\Facades\Auth::id();
            $view->with('storyStatus', $service->handle($userId));
        });
    }
}
