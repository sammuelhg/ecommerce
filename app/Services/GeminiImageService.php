<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GeminiImageService
{
    private string $apiKey;
    private string $projectId = 'gen-lang-client-0809483605';

    public function __construct()
    {
        $this->apiKey = \App\Models\StoreSetting::get('gemini_api_key') ?: config('services.gemini.api_key', 'AIzaSyDipBtMGE_V9oqIsTatKLC0uqdXHIEPrWc');
    }

    /**
     * Generate an image using Google Imagen API based on product data
     *
     * @param array $productData
     * @return string|null Path to saved image or null on failure
     */
    public function generateProductImage(array $productData): ?string
    {
        $prompt = $this->buildPrompt($productData);
        return $this->generateProductImageWithPrompt($productData, $prompt);
    }

    /**
     * Generate an image using Google Imagen API with a specific prompt
     *
     * @param array $productData
     * @param string $prompt
     * @return string|null Path to saved image or null on failure
     */
    public function generateProductImageWithPrompt(mixed $productData, string $prompt): ?string
    {
        // Handle both array and object for productData
        $productId = is_array($productData) ? ($productData['id'] ?? null) : ($productData->id ?? null);
        $productName = is_array($productData) ? ($productData['name'] ?? null) : ($productData->name ?? null);

        Log::info('AI Image Generation Started', [
            'product_id' => $productId,
            'product_name' => $productName,
            'prompt_length' => strlen($prompt)
        ]);

        // Try Google Imagen first
        $imagePath = $this->generateWithImagen($prompt, is_array($productData) ? $productData : ['id' => $productId]);
        
        // If Imagen fails, fallback to Pollinations
        if (!$imagePath) {
            Log::warning('Imagen failed, using Pollinations fallback');
            $imagePath = $this->generateWithPollinations($prompt, is_array($productData) ? $productData : ['id' => $productId]);
        }

        return $imagePath;
    }

    /**
     * Resize and optimize image data
     */
    private function optimizeImage($imageData, $format = 'png')
    {
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageData);
            
            // Resize if larger than 1200px (scaleDown maintains aspect ratio and prevents upsizing)
            $image->scaleDown(width: 1200, height: 1200);
            
            if ($format === 'png') {
                return (string) $image->toPng();
            } else {
                return (string) $image->toJpeg(quality: 90);
            }
        } catch (\Exception $e) {
            Log::warning('Image optimization failed, using original', ['error' => $e->getMessage()]);
            return $imageData;
        }
    }

    /**
     * Generate image using Google Imagen API
     */
    private function generateWithImagen(string $prompt, array $productData): ?string
    {
        try {
            Log::info('Attempting Imagen generation');

            // Google Imagen API endpoint
            $url = "https://generativelanguage.googleapis.com/v1beta/models/imagen-3.0-generate-001:predict?key={$this->apiKey}";

            $response = Http::timeout(120)
                ->post($url, [
                    'instances' => [
                        [
                            'prompt' => $prompt
                        ]
                    ],
                    'parameters' => [
                        'sampleCount' => 1,
                        'aspectRatio' => '1:1',
                        'negativePrompt' => 'blurry, low quality, distorted, text overlay, watermark, ugly',
                        'addWatermark' => false,
                        'safetySetting' => 'block_few',
                        'personGeneration' => 'dont_allow'
                    ]
                ]);

            if (!$response->successful()) {
                Log::error('Imagen API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return null;
            }

            $result = $response->json();
            
            // Extract image from response
            if (isset($result['predictions'][0]['bytesBase64Encoded'])) {
                $imageData = base64_decode($result['predictions'][0]['bytesBase64Encoded']);
            } elseif (isset($result['predictions'][0]['image'])) {
                // Alternative response format
                $imageData = base64_decode($result['predictions'][0]['image']);
            } else {
                Log::error('Unexpected Imagen response format', ['response' => $result]);
                return null;
            }

            // Optimize image
            $imageData = $this->optimizeImage($imageData, 'png');

            // Save the image
            $filename = 'products/ai-generated/imagen_' . uniqid() . '_' . time() . '.png';
            Storage::disk('public')->put($filename, $imageData);
            
            Log::info('Imagen image generated successfully', [
                'product_id' => $productData['id'] ?? null,
                'filename' => $filename,
                'size' => strlen($imageData)
            ]);

            return $filename;

        } catch (\Exception $e) {
            Log::error('Imagen Generation Failed', [
                'error' => $e->getMessage(),
                'trace' => substr($e->getTraceAsString(), 0, 500)
            ]);
            return null;
        }
    }

    /**
     * Generate image using Pollinations AI (fallback)
     */
    private function generateWithPollinations(string $prompt, array $productData): ?string
    {
        try {
            $encodedPrompt = urlencode($prompt);
            $imageUrl = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=1200&height=1200&nologo=true&enhance=true";
            
            Log::info('Fetching image from Pollinations.ai');

            $response = Http::timeout(120)->get($imageUrl);

            if (!$response->successful()) {
                Log::error('Pollinations API Error', [
                    'status' => $response->status()
                ]);
                return null;
            }

            $imageData = $response->body();
            
            // Optimize image (ensure it is resized if API didn't respect it, and optimize quality)
            $imageData = $this->optimizeImage($imageData, 'jpg');
            
            $filename = 'products/ai-generated/pollinations_' . uniqid() . '_' . time() . '.jpg';
            
            Storage::disk('public')->put($filename, $imageData);
            
            Log::info('Pollinations image generated successfully', [
                'product_id' => $productData['id'] ?? null,
                'filename' => $filename
            ]);

            return $filename;

        } catch (\Exception $e) {
            Log::error('Pollinations Generation Failed', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Build optimized prompt for image generation
     * Uses template from store settings with variable replacement
     */
    /**
     * Build optimized prompt for image generation
     * Uses template from store settings with variable replacement
     */
    private function buildPrompt(array $data): string
    {
        // Use the new AiContentService to build the prompt to ensure consistency across the application
        // If AiContentService is not found or fails, we fall back to local logic (which is now identical)
        try {
            return app(\App\Services\AiContentService::class)->buildImagePrompt($data);
        } catch (\Exception $e) {
            Log::warning('AiContentService not available, using fallback prompt logic', ['error' => $e->getMessage()]);
            
            // Fallback logic (Identical to AiContentService for robustness)
            $template = \App\Models\StoreSetting::get('ai_image_prompt_template', 
                'Professional e-commerce product photography of {product_name}, {category} category, {model} model. The product features a {color} color palette and visual cues of {flavor} flavor (if applicable). {material} texture details. Studio lighting, clean white background, product centered, front view, label visible and readable, 8k quality, photorealistic, commercial packshot.'
            );
    
            $categoria = $data['category'] ?? '';
            $titulo = $data['name'] ?? 'Produto';
            $modelo = $data['model'] ?? '';
            $sabor = $data['flavor'] ?? '';
            $cor = $data['color'] ?? '';
            $material = $data['material'] ?? '';
    
            $replacements = [
                '{product_name}' => $titulo,
                '{category}' => $categoria,
                '{model}' => $modelo,
                '{color}' => $cor ?: 'neutral',
                '{flavor}' => $sabor,
                '{material}' => $material,
            ];
    
            $prompt = $template;
            foreach ($replacements as $variable => $value) {
                if (empty($value) && $variable === '{flavor}') {
                     $prompt = str_replace('and visual cues of {flavor} flavor (if applicable)', '', $prompt); 
                     $prompt = str_replace('{flavor}', '', $prompt);
                } else {
                    $prompt = str_replace($variable, (string)$value, $prompt);
                }
            }
    
            $prompt = preg_replace('/\s+/', ' ', $prompt);
            return trim($prompt);
        }
    }
}
