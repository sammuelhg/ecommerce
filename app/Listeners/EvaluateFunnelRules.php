<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Domains\Marketing\Models\FunnelAutomation;
use App\Domains\Marketing\Models\Lead;
use App\Enums\FunnelTriggerEnum;
use App\Enums\FunnelActionEnum;
use App\Enums\LeadStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class EvaluateFunnelRules implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Log::info('EvaluateFunnelRules: Processing event ' . get_class($event));

        $leads = collect();
        $triggerType = null;

        // 1. Identify Trigger and Lead(s) based on Event Type
        if ($event instanceof OrderPaid) {
            $triggerType = FunnelTriggerEnum::ORDER_PAID;
            
            // Should optimize: Find leads by email of the order
            // Assuming Order has 'email' or 'user_id'
            // Let's check Order model later, assuming it has 'email' or relation to User->email.
            // For now, let's grab the email from the order object directly if public parameter.
            // Adjust based on user's Order model reality.
            
            $email = $event->order->email ?? null; // Adjust based on Order model
            if ($email) {
                // Find all active leads with this email
                $leads = Lead::where('email', $email)->get();
            }
        }

        if (!$triggerType || $leads->isEmpty()) {
            Log::info("EvaluateFunnelRules: No relevant leads or trigger found.");
            return;
        }

        // 2. Fetch Active Rules for this Trigger
        $rules = FunnelAutomation::where('is_active', true)
            ->where('trigger_event', $triggerType)
            ->get();

        if ($rules->isEmpty()) {
            return;
        }

        // 3. Evaluate Rules for Each Lead
        foreach ($leads as $lead) {
            foreach ($rules as $rule) {
                $this->applyRule($rule, $lead, $event);
            }
        }
    }

    protected function applyRule(FunnelAutomation $rule, Lead $lead, object $event): void
    {
        // Check conditions (operator/value) if needed. 
        // For 'order_paid', we usually just check if it happened.
        // Future: Check min order value using $rule->trigger_operator
        
        Log::info("EvaluateFunnelRules: Applying Rule #{$rule->id} ({$rule->name}) to Lead #{$lead->id}");

        if ($rule->action_type === FunnelActionEnum::MOVE_LEAD_STAGE->value) {
            $payload = $rule->action_payload;
            $targetStatus = $payload['target_status'] ?? null;

            if ($targetStatus) {
                // Validate if target status is valid Enum
                // We'll update regardless for now
                $lead->status = $targetStatus;
                $lead->save();
                
                Log::info("EvaluateFunnelRules: Lead moved to {$targetStatus}");
            }
        }
    }
}
