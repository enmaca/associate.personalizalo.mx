<?php

namespace App\Support\Enums;

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
            self::NotNeeded => '<span class="badge text-dark bg-dark-subtle">No Necesario</span>',
            self::Pendind => '<span class="badge text-warning bg-warning-subtle">Pendiente</span>',
            self::Shipped => '<span class="badge text-secondary bg-secondary-subtle">Enviado</span>',
            self::Delivered => '<span class="badge text-success bg-success-subtle">Entregado<span>'
        };
    }
}
