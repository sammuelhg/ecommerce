<?php

declare(strict_types=1);

namespace App\Enums;

enum LeadStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case UNSUBSCRIBED = 'unsubscribed';
    case BOUNCED = 'bounced';
    case COMPLAINED = 'complained';

    // Sales Pipeline Statuses
    case NEW = 'new';
    case OPENED = 'opened';
    case CLICKED = 'clicked';
    case CONVERTED = 'converted';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Ativo',
            self::INACTIVE => 'Inativo',
            self::UNSUBSCRIBED => 'Cancelado',
            self::BOUNCED => 'Email Inválido',
            self::COMPLAINED => 'Denúncia',
            self::NEW => 'Novo',
            self::OPENED => 'Aberto',
            self::CLICKED => 'Clicou',
            self::CONVERTED => 'Convertido',
        };
    }
}
