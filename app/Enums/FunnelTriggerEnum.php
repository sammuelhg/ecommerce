<?php

namespace App\Enums;

enum FunnelTriggerEnum: string
{
    case ORDER_PAID = 'order_paid';
    // case EMAIL_OPENED = 'email_opened'; // Future
    // case LINK_CLICKED = 'link_clicked'; // Future
    
    public function label(): string
    {
        return match($this) {
            self::ORDER_PAID => 'Pedido Pago ✅',
            // self::EMAIL_OPENED => 'Email Aberto 📩',
            // self::LINK_CLICKED => 'Link Clicado 🔗',
        };
    }
}
