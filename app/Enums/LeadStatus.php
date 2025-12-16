<?php

declare(strict_types=1);

namespace App\Enums;

enum LeadStatus: string
{
    case NEW = 'new';
    case OPENED = 'opened'; // Keep for backward compatibility if needed, or map to HOT? Let's keep it but focus on new ones.
    case HOT = 'hot'; // Quente / Em Análise
    case CUSTOMER = 'customer'; // Cliente
    case LOYAL = 'loyal'; // VIP / Recorrente
    case RECOVERY = 'recovery'; // Recuperação / Churn
    case CONVERTED = 'converted'; // Legacy, maybe map to CUSTOMER
}
