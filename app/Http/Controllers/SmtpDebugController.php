<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class SmtpDebugController extends Controller
{
    public function index()
    {
        $results = [
            'config' => $this->checkConfig(),
            'connection' => $this->checkConnection(),
            'sending' => $this->testSend(),
            'campaigns' => $this->getCampaigns(),
            'logs' => $this->getRecentLogs(),
        ];

        return response()->json($results, 200, [], JSON_PRETTY_PRINT);
    }

    private function getCampaigns()
    {
        try {
            return [
                'status' => 'info',
                'count' => \App\Models\NewsletterCampaign::count(),
                'items' => \App\Models\NewsletterCampaign::withCount('emails')->get()->map(function($c) {
                    return [
                        'id' => $c->id,
                        'name' => $c->name,
                        'subject' => $c->subject,
                        'is_active' => $c->is_active,
                        'emails_count' => $c->emails_count,
                        'created_at' => $c->created_at->toDateTimeString()
                    ];
                })
            ];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function checkConfig()
    {
        $config = Config::get('mail.mailers.smtp');
        
        // Mask password for safety
        if (isset($config['password'])) {
            $config['password'] = '***' . substr($config['password'], -3);
        }

        return [
            'status' => 'info',
            'values' => $config
        ];
    }

    private function checkConnection()
    {
        $host = Config::get('mail.mailers.smtp.host');
        $port = Config::get('mail.mailers.smtp.port');
        
        $startTime = microtime(true);
        $connected = @fsockopen($host, $port, $errno, $errstr, 5);
        $duration = round((microtime(true) - $startTime) * 1000, 2);

        if ($connected) {
            fclose($connected);
            return [
                'status' => 'success',
                'message' => "Connected to $host:$port in {$duration}ms",
            ];
        }

        return [
            'status' => 'error',
            'message' => "Could not connect to $host:$port. Error: $errstr ($errno)",
        ];
    }

    private function testSend()
    {
        try {
            Mail::raw('This is a test email from the SMTP Debug Tool.', function ($message) {
                $message->to(Config::get('mail.from.address'))
                        ->subject('SMTP Debug Test');
            });

            return [
                'status' => 'success',
                'message' => 'Email sent successfully (Synchronous check).',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ];
        }
    }

    private function getRecentLogs($lines = 20)
    {
        $logPath = storage_path('logs/laravel.log');
        
        if (!File::exists($logPath)) {
            return ['status' => 'warning', 'message' => 'Log file not found.'];
        }

        try {
            // Efficiently read last N lines
            $file = new \SplFileObject($logPath, 'r');
            $file->seek(PHP_INT_MAX);
            $totalLines = $file->key();
            
            $startLine = max(0, $totalLines - $lines);
            $file->seek($startLine);
            
            $content = [];
            while (!$file->eof()) {
                $line = $file->fgets();
                if (trim($line)) {
                     $content[] = $line;
                }
            }

            return [
                'status' => 'info',
                'content' => $content
            ];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Could not read logs: ' . $e->getMessage()];
        }
    }
}
