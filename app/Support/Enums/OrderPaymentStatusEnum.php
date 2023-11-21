<?php

namespace App\Support\Enums;

//'pending','partial','completed'
enum OrderPaymentStatusEnum: string
{
    case Pending = 'pending';

    case Partial = 'partial';

    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Partial => 'Parcial',
            self::Completed => 'Completo'
        };
    }
}
