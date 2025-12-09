<?php

declare(strict_types=1);

namespace App\Enums;

enum CampaignStatus: string
{
    case DRAFT = 'draft';
    case SCHEDULED = 'scheduled';
    case SENT = 'sent';
    case FAILED = 'failed';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Rascunho',
            self::SCHEDULED => 'Agendado',
            self::SENT => 'Enviado',
            self::FAILED => 'Falhou',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::SCHEDULED => 'warning',
            self::SENT => 'success',
            self::FAILED => 'danger',
        };
    }
}
