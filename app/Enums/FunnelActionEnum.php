<?php

namespace App\Enums;

enum FunnelActionEnum: string
{
    case MOVE_LEAD_STAGE = 'move_lead_stage';
    
    public function label(): string
    {
        return match($this) {
            self::MOVE_LEAD_STAGE => 'Mover Lead de Coluna ➡️',
        };
    }
}
