<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateLeadAction;
use App\DTOs\LeadDTO;
use App\Services\UtmExtractorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadCaptureController extends Controller
{
    public function __construct(
        private readonly CreateLeadAction $createLeadAction,
        private readonly UtmExtractorService $utmExtractor
    ) {}

    /**
     * Handle the incoming request.
     */
    public function store(Request $request): JsonResponse
    {
        // 1. Validate Request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Extract UTMs
        $trackingData = $this->utmExtractor->extract($request);

        // 3. Create DTO
        $dto = new LeadDTO(
            email: $request->input('email'),
            name: $request->input('name'),
            phone: $request->input('phone'),
            source: $request->input('source', 'api'),
            status: \App\Enums\LeadStatus::ACTIVE,
            utm_source: $trackingData->utm_source,
            utm_medium: $trackingData->utm_medium,
            utm_campaign: $trackingData->utm_campaign,
            utm_content: $trackingData->utm_content,
            meta: [] // We can add more meta if needed
        );

        // 4. Execute Action
        try {
            $this->createLeadAction->execute($dto);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to capture lead: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Lead captured successfully'
        ], 201);
    }
}
