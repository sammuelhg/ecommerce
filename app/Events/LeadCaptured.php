<?php

declare(strict_types=1);

namespace App\Events;

use App\Domains\Marketing\Models\Form;
use App\Domains\Marketing\Models\Lead;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadCaptured
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Lead $lead,
        public Form $form
    ) {}
}
