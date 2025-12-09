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

        // UTM Tracking
        $lead->utm_source = $dto->utm_source ?? $lead->utm_source;
        $lead->utm_medium = $dto->utm_medium ?? $lead->utm_medium;
        $lead->utm_campaign = $dto->utm_campaign ?? $lead->utm_campaign;
        $lead->utm_content = $dto->utm_content ?? $lead->utm_content;
        
        // Update/Merge meta JSON if needed (simplified for now)
        $lead->meta = array_merge($lead->meta ?? [], $dto->meta);

        $lead->save();

        Log::info("Lead Processed: {$lead->email}", ['id' => $lead->id]);

        return $lead;
    }
}
