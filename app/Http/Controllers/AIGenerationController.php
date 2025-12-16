<?php

namespace App\Http\Controllers;

use App\Services\AiContentService;
use Illuminate\Http\Request;

class AIGenerationController extends Controller
{
    public function generate(Request $request, AiContentService $aiService)
    {
        // Validação básica do prompt
        $request->validate(['prompt' => 'required|string|max:1000']);
        
        $prompt = $request->input('prompt');

        // Chama o serviço de IA
        $generatedText = $aiService->generateText($prompt);

        if (!$generatedText) {
            return response()->json([
                'error' => 'Failed to generate content. Please check API configuration.'
            ], 500);
        }

        return response()->json([
            'prompt' => $prompt,
            'generated_text' => $generatedText
        ]);
    }
}
