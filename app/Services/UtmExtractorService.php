<?php

declare(strict_types=1);

namespace App\Services;

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
        return \App\DTOs\TrackingDataDTO::fromRequest($request);
    }
}
