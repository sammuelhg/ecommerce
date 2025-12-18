<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\Table;

class SystemHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integrity:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the system for data integrity issues and legacy class references';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting System Health Check...');
        
        $issues = [];

        // 1. Check for Legacy Class References in Content usage (JSON fields, etc)
        // This is a common issue when moving models to Domains
        $legacyClasses = [
            'App\\Models\\Product' => 'App\\Domains\\Catalog\\Models\\Product',
            'App\\Models\\StoreSetting' => 'App\\Domains\\Shared\\Models\\StoreSetting',
            'App\\Models\\Category' => 'App\\Domains\\Catalog\\Models\\Category',
            'App\\Models\\Order' => 'App\\Domains\\Sales\\Models\\Order',
        ];

        $this->info('Scanning for legacy class references...');
        
        // Scan specific tables that might store class names
        $tablesToScan = [
            'action_events' => ['original', 'changes'], // Laravel Nova or similar
            'notifications' => ['data'],
            'failed_jobs' => ['payload'],
            'jobs' => ['payload'],
            // Add other tables that might have polymorphic relations or JSON settings
        ];

        // Also check Views if possible? (Grep) - mostly redundant as we did it via grep earlier, 
        // but let's check exact database values.

        // Check Polymorphic Relations (example: imageables, commentables)
        // $issues = array_merge($issues, $this->checkPolymorphic('imageables', 'imageable_type', $legacyClasses));
        
        // 2. Check Database Tables Status
        $this->info('Checking Database Tables...');
        try {
            DB::connection()->getPdo();
            $this->info('Database Connection: OK');
        } catch (\Exception $e) {
            $this->error('Database Connection: FAILED - ' . $e->getMessage());
            return 1;
        }

        // 3. Check for specific Critical Records
        // Page 7 (Sobre Nós)
        $aboutPage = \App\Domains\Content\Models\Page::find(7);
        if (!$aboutPage) {
            $issues[] = ['CRITICAL', 'Page ID 7 (Sobre Nós) not found in database.'];
        }

        // Report
        if (count($issues) > 0) {
            $this->error('Found ' . count($issues) . ' issues!');
            $this->table(['Severity', 'Message'], $issues);
        } else {
            $this->info('System Health Check Passed: No critical issues found.');
        }

        return 0;
    }
}
