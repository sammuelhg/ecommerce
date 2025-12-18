<?php

namespace App\Livewire\Admin\Leads;


use Livewire\Component;
use App\Domains\Marketing\Models\Lead;
use App\Enums\LeadStatus;
use Illuminate\Support\Facades\Mail;
use App\Mail\Crm\LeadHotMail;
use App\Mail\Crm\LeadRecoveryMail;

class LeadKanban extends Component
{
    public $confirmingStatusChange = false;
    public $pendingLeadId;
    public $pendingStatus;
    public $shouldSendEmail = true;

    public function updateStatus($leadId, $status)
    {
        $this->pendingLeadId = $leadId;
        $this->pendingStatus = $status;
        
        // Check if this status has an associated email automation
        if (in_array($status, ['hot', 'recovery'])) {
            $this->confirmingStatusChange = true;
            $this->shouldSendEmail = true; // Default to yes
        } else {
            // No automation, just update
            $this->processStatusUpdate(false);
        }
    }

    public function confirmUpdate()
    {
        $this->processStatusUpdate($this->shouldSendEmail);
        $this->confirmingStatusChange = false;
    }

    public function cancelUpdate()
    {
        $this->confirmingStatusChange = false;
        $this->reset(['pendingLeadId', 'pendingStatus']);
    }

    protected function processStatusUpdate($sendEmail)
    {
        $lead = Lead::find($this->pendingLeadId);
        
        if ($lead) {
            $lead->update(['status' => $this->pendingStatus]);

            if ($sendEmail) {
                switch ($this->pendingStatus) {
                    case 'hot':
                        Mail::to($lead->email)->send(new LeadHotMail($lead->name ?? 'Cliente'));
                        break;
                    case 'recovery':
                        Mail::to($lead->email)->send(new LeadRecoveryMail($lead->name ?? 'Cliente'));
                        break;
                }
            }
        }
    }

    public function render()
    {
        // Optimizing: limit to last 200 leads to prevent memory/timeout issues
        // TODO: Implement pagination or infinite scroll for Kanban
        $leads = Lead::latest()->take(200)->get()->groupBy('status.value');
        
        return view('livewire.admin.leads.lead-kanban', [
            'columns' => [
                'new' => ['title' => 'Novos', 'leads' => $leads['new'] ?? []],
                'hot' => ['title' => 'Quentes', 'leads' => $leads['hot'] ?? []],
                'customer' => ['title' => 'Clientes', 'leads' => $leads['customer'] ?? []],
                'loyal' => ['title' => 'VIP/Fiéis', 'leads' => $leads['loyal'] ?? []],
                'recovery' => ['title' => 'Recuperação', 'leads' => $leads['recovery'] ?? []],
            ]
        ])->layout('layouts.admin');
    }
}
