<?php

namespace App\Livewire\Admin\Funnel;

use Livewire\Component;
use App\Models\FunnelAutomation;
use App\Enums\FunnelTriggerEnum;
use App\Enums\FunnelActionEnum;
use App\Enums\LeadStatus;

class FunnelAutomationManager extends Component
{
    public $rules;
    public $isCreating = false;
    
    // Form Inputs
    public $name;
    public $trigger_event = 'order_paid'; // Default
    public $action_type = 'move_lead_stage'; // Default
    public $target_status = 'customer'; // Part of payload

    protected $rules_validation = [
        'name' => 'required|string|max:255',
        'trigger_event' => 'required',
        'target_status' => 'required',
    ];

    public function mount()
    {
        $this->loadRules();
    }

    public function loadRules()
    {
        $this->rules = FunnelAutomation::all();
    }

    public function create()
    {
        $this->isCreating = true;
        $this->reset(['name', 'target_status']);
    }

    public function cancel()
    {
        $this->isCreating = false;
    }

    public function save()
    {
        $this->validate($this->rules_validation);

        FunnelAutomation::create([
            'name' => $this->name,
            'trigger_event' => $this->trigger_event,
            'trigger_operator' => '==', // Simplification for MVP
            'trigger_value' => null,
            'action_type' => $this->action_type,
            'action_payload' => ['target_status' => $this->target_status],
            'is_active' => true,
        ]);

        $this->isCreating = false;
        $this->loadRules();
    }

    public function toggle($id)
    {
        $rule = FunnelAutomation::find($id);
        if ($rule) {
            $rule->is_active = !$rule->is_active;
            $rule->save();
        }
        $this->loadRules();
    }

    public function delete($id)
    {
        FunnelAutomation::destroy($id);
        $this->loadRules();
    }

    public function render()
    {
        return view('livewire.admin.funnel.funnel-automation-manager', [
            'leadStatuses' => LeadStatus::cases(),
            'triggers' => FunnelTriggerEnum::cases(),
        ])->layout('layouts.admin');
    }
}
