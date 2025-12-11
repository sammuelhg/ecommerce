<?php

declare(strict_types=1);

namespace App\Actions\Leads;

use App\DTOs\LeadData;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;

class CreateLeadAction
{
    public function execute(LeadData $data): Lead
    {
        // Check if lead already exists by email
        $lead = Lead::firstOrNew(['email' => $data->email]);

        // Update basic fields
        $lead->name = $data->name ?? $lead->name;
        $lead->phone = $data->phone ?? $lead->phone;
        $lead->source = $data->source ?? $lead->source;
        $lead->status = $data->status->value ?? $lead->status;

        // UTM Tracking
        $utmData = [
            'utm_source' => $data->utm_source,
            'utm_medium' => $data->utm_medium,
            'utm_campaign' => $data->utm_campaign,
            'utm_content' => $data->utm_content,
        ];

        // Clean nulls
        $utmData = array_filter($utmData, fn($v) => !is_null($v));

        // Update/Merge data JSON
        $lead->data = array_merge($lead->data ?? [], $data->meta, $utmData);

        $lead->save();

        Log::info("Lead Processed: {$lead->email}", ['id' => $lead->id]);

        return $lead;
    }
}
