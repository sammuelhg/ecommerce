<?php

require 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = \App\Models\StoreSetting::get('gemini_api_key') ?: config('services.gemini.api_key');

if (empty($apiKey)) {
    echo "API Key not found.\n";
    exit(1);
}

echo "Using API Key: " . substr($apiKey, 0, 5) . "...\n";

$response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}");

if ($response->successful()) {
    $models = $response->json()['models'] ?? [];
    foreach ($models as $model) {
        if (strpos($model['name'], 'gemini') !== false && in_array('generateContent', $model['supportedGenerationMethods'] ?? [])) {
            echo "Model: " . $model['name'] . "\n";
        }
    }
} else {
    echo "Error: " . $response->body() . "\n";
}
