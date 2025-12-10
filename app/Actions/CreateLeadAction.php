<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\LeadDTO;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;

class CreateLeadAction
{
    public function execute(LeadDTO $dto): Lead
    {
        // Check if lead already exists by email
        $lead = Lead::firstOrNew(['email' => $dto->email]);

        // Update basic fields
        $lead->name = $dto->name ?? $lead->name;
        $lead->phone = $dto->phone ?? $lead->phone;
        $lead->source = $dto->source ?? $lead->source;
        $lead->status = $dto->status ?? $lead->status;

        // UTM Tracking (Store in META since table lacks columns)
        $utmData = [
            'utm_source' => $dto->utm_source,
            'utm_medium' => $dto->utm_medium,
            'utm_campaign' => $dto->utm_campaign,
            'utm_content' => $dto->utm_content,
        ];

        // Clean nulls
        $utmData = array_filter($utmData, fn($v) => !is_null($v));

        // Update/Merge meta JSON
        $lead->meta = array_merge($lead->meta ?? [], $dto->meta, $utmData);

        $lead->save();

        Log::info("Lead Processed: {$lead->email}", ['id' => $lead->id]);

        return $lead;
    }
}
