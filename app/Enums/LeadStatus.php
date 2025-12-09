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

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Ativo',
            self::INACTIVE => 'Inativo',
            self::UNSUBSCRIBED => 'Cancelado',
            self::BOUNCED => 'Email Inválido',
            self::COMPLAINED => 'Denúncia',
        };
    }
}
