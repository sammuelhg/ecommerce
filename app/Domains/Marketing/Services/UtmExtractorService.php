<?php

declare(strict_types=1);

namespace App\Domains\Marketing\Services;

use Illuminate\Http\Request;

class UtmExtractorService
{
    private const UTM_FIELDS = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    /**
     * Extract UTM parameters from request.
     * 
     * @param Request $request
     * @return array
     */
    public function extract(Request $request): \App\DTOs\TrackingDataDTO
    {
        // 1. Get from Request
        $requestData = [];
        foreach (self::UTM_FIELDS as $field) {
            if ($request->has($field)) {
                $requestData[$field] = $request->input($field);
            }
        }

        // 2. Get from Session
        $sessionData = session('utm_tracking', []);

        // 3. Merge (Request takes precedence if new params are present)
        $finalData = array_merge($sessionData, $requestData);

        return new \App\DTOs\TrackingDataDTO(
            utm_source: $finalData['utm_source'] ?? null,
            utm_medium: $finalData['utm_medium'] ?? null,
            utm_campaign: $finalData['utm_campaign'] ?? null,
            utm_term: $finalData['utm_term'] ?? null,
            utm_content: $finalData['utm_content'] ?? null
        );
    }
}
