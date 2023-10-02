<?php

namespace App\Enums;

enum ShipmentStatusEnum: string
{
    // not_needed', 'ready', 'pending')
    case NotNeeded = 'not_needed';
    case Pendind = 'pending';
    case Shipped = 'shipped';

    case Delivered = 'delivered';

    public function label(): string
    {
        return match ($this) {
            self::NotNeeded => 'No Necesario',
            self::Pendind => 'Pendiente',
            self::Shipped => 'Enviado',
            self::Delivered => 'Entregado'
        };
    }
}
