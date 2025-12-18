<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Scan all domains in app/Domains
        if (File::exists(app_path('Domains'))) {
            $domains = File::directories(app_path('Domains'));

            foreach ($domains as $domain) {
                $domainName = basename($domain);
                
                // 1. Register Domain Service Providers
                // Convention: app/Domains/{Domain}/Providers/{Domain}ServiceProvider.php
                $providerClass = "App\\Domains\\{$domainName}\\Providers\\{$domainName}ServiceProvider";
                if (class_exists($providerClass)) {
                    $this->app->register($providerClass);
                }
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Scan all domains in app/Domains
        if (File::exists(app_path('Domains'))) {
            $domains = File::directories(app_path('Domains'));

            foreach ($domains as $domain) {
                // 2. Load Migrations
                // Convention: app/Domains/{Domain}/Database/Migrations
                $migrationPath = $domain . '/Database/Migrations';
                if (File::exists($migrationPath)) {
                    $this->loadMigrationsFrom($migrationPath);
                }

                // 3. Load Routes (Optional/Simple approach)
                // Convention: app/Domains/{Domain}/Routes/web.php or api.php can be loaded here if needed.
                // For now, we focus on Structural discovery.
            }
        }
    }
}
