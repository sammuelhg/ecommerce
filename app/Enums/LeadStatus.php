<?php

declare(strict_types=1);

namespace App\Enums;

enum LeadStatus: string
{
    case NEW = 'new';
    case OPENED = 'opened';
    case CONVERTED = 'converted';
    case UNIG = 'unig';
}
