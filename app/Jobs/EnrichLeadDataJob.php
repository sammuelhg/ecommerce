<?php

namespace App\Jobs;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnrichLeadDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Lead $lead
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Aqui entraria a lógica de enriquecimento de dados (Clearbit, Hunter.io, etc)
        // Por enquanto, apenas atualizamos o status se ainda for 'new'
        
        if ($this->lead->status === 'new') {
            // Simular processamento
            // $this->lead->update(['status' => 'processed']); 
            
            // Log for audit
            \Log::info("Lead {$this->lead->id} enriched.");
        }
    }
}
