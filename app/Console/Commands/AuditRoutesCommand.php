<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuditRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Audit all registered GET routes for 500 and 403 errors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Route Audit...');

        // 1. Get all routes
        $routes = Route::getRoutes();
        $results = [];

        // 2. Login as Admin to ensure we can access protected routes
        // Adjust ID or email as needed. Assuming ID 1 is admin.
        $admin = User::first(); 
        if ($admin) {
            $this->info("Authenticated as: " . $admin->email);
            Auth::login($admin);
        } else {
            $this->warn("No user found. Running as guest.");
        }

        $baseUrl = url('/');
        $this->info("Base URL: $baseUrl");

        foreach ($routes as $route) {
            if (!in_array('GET', $route->methods())) {
                continue;
            }

            $uri = $route->uri();
            
            if (str_starts_with($uri, '_') || str_starts_with($uri, 'api/') || in_array($uri, ['shop', 'loja', 'loja2', 'loja/busca', 'loja/busca/sugestoes', 'loja/checkout', 'conta/perfil', 'meus-pedidos', 'notificacoes', 'pagamentos', 'presentes', 'indique-amigos', 'enderecos', 'cupons', 'card', 'clube'])) {
                 $this->line("Skipped: $uri (Known timeout)");
                 continue;
            }

            // Prepare URL with dummy data for parameters
            $url = $this->prepareUrl($uri);

            if (!$url) {
                $results[] = [
                    'method' => 'GET',
                    'uri' => $uri,
                    'status' => 'SKIPPED',
                    'message' => 'Dynamic parameters missing'
                ];
                $this->line("Skipped: $uri (Missing params)");
                continue;
            }

            $this->output->write("Checking $uri ... ");

            try {
                $request = \Illuminate\Http\Request::create($url, 'GET');
                
                // Hack: Set user resolver for the new request if possible, 
                // but app()->handle() creates a fresh request instance mostly.
                // However, session persistence is key.
                // Since we are in CLI, session driver 'array' is often used, or 'file'.
                // If 'file', cookies mismatch.
                // Let's rely on manual Auth login persisting in the application instance for now.
                
                $response = app()->handle($request);
                $status = $response->getStatusCode();
                
                $color = 'green';
                if ($status >= 500) $color = 'red';
                elseif ($status >= 400) $color = 'yellow';
                
                $results[] = [
                    'method' => 'GET',
                    'uri' => $uri,
                    'status' => $status,
                    'color' => $color,
                    'message' => $status == 200 ? 'OK' : 'Error'
                ];
                
                $tag = $status == 200 ? 'INFO' : ($status >= 500 ? 'ERROR' : 'WARN');
                $this->line("[$status]");

            } catch (\Throwable $e) {
                $results[] = [
                    'method' => 'GET',
                    'uri' => $uri,
                    'status' => 500,
                    'color' => 'red',
                    'message' => $e->getMessage()
                ];
                $this->error("EXCEPTION: " . $e->getMessage());
            }
        }

        $this->table(
            ['Method', 'URI', 'Status', 'Message'],
            array_map(function($r) {
                return [
                    $r['method'],
                    $r['uri'],
                    $r['color'] === 'red' ? "<error>{$r['status']}</error>" : ($r['color'] === 'yellow' ? "<comment>{$r['status']}</comment>" : "<info>{$r['status']}</info>"),
                    $r['message']
                ];
            }, $results)
        );
        
        // Also save to a file for review
        $reportPath = storage_path('audit_report.json');
        file_put_contents($reportPath, json_encode($results, JSON_PRETTY_PRINT));
        $this->info("Report saved to $reportPath");
    }

    private function prepareUrl($uri)
    {
        // Simple heuristic for common params
        // {product} -> get first product
        // {id} -> 1
        
        $path = $uri;
        
        if (str_contains($path, '{')) {
            // This is a naive replacements. For a real audit we might need more logic
            // or specific mappings.
            
            // If it requires parameters and we don't know them, return null to skip
            // But let's try some defaults.
            
            if (str_contains($path, '{product}')) {
                 $path = str_replace('{product}', 'sample-product-slug', $path); // Adjust if we can fetch a real slug
            }
            
            if (str_contains($path, '{id}')) {
                 $path = str_replace('{id}', '1', $path);
            }
            
             // If still has braces, skip
            if (str_contains($path, '{')) {
                return null;
            }
        }
        
        return $path;
    }
}
