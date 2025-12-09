<?php

declare(strict_types=1);


declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class LogViewerController extends Controller
{
    public function index()
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logPath)) {
            // Read file into array
            $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            // Get last 2000 lines to avoid memory issues
            $lines = array_slice($lines, -2000);
            
            // Reverse to show newest first
            $lines = array_reverse($lines);

            foreach ($lines as $line) {
                // Parse Date
                preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/', $line, $dateMatch);
                $date = $dateMatch[1] ?? 'N/A';

                // Check for Contact Form Logs
                if (str_contains($line, 'Contact Form Submission')) {
                    $jsonStart = strpos($line, '{');
                    $data = $jsonStart !== false ? json_decode(substr($line, $jsonStart), true) : [];
                    
                    $logs[] = [
                        'type' => 'Contact Form',
                        'status' => 'Received',
                        'date' => $date,
                        'recipient' => 'System',
                        'details' => 'From: ' . ($data['name'] ?? 'N/A') . ' (' . ($data['email'] ?? 'N/A') . ')',
                        'class' => 'info'
                    ];
                }
                elseif (str_contains($line, 'Contact Email SENT successfully')) {
                    $logs[] = [
                        'type' => 'Contact Email',
                        'status' => 'Sent',
                        'date' => $date,
                        'recipient' => trim(explode('to:', $line)[1] ?? 'Admin'),
                        'details' => 'SMTP Handshake Successful',
                        'class' => 'success'
                    ];
                }
                elseif (str_contains($line, 'Contact Email FAILED')) {
                    $logs[] = [
                        'type' => 'Contact Email',
                        'status' => 'Failed',
                        'date' => $date,
                        'recipient' => 'Admin',
                        'details' => trim(explode('send:', $line)[1] ?? 'Error'),
                        'class' => 'danger'
                    ];
                }
                // Check for Highlights Logs
                elseif (str_contains($line, 'Sending Highlights Email')) {
                    $jsonStart = strpos($line, '{');
                    $data = $jsonStart !== false ? json_decode(substr($line, $jsonStart), true) : [];

                    $logs[] = [
                        'type' => 'Highlights Email',
                        'status' => 'Processing',
                        'date' => $date,
                        'recipient' => $data['recipient'] ?? 'N/A',
                        'details' => 'Title: ' . ($data['title'] ?? 'N/A'),
                        'class' => 'warning'
                    ];
                }
            }
        }

        return view('admin.logs.email-logs', ['logs' => $logs]);
    }
}
