<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case Incomplete = 'created';
    case New = 'new';
    case Processing = 'processing';
    case Finished = 'finished';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::Incomplete => 'Incompleto',
            self::New => 'Nuevo',
            self::Processing => 'En proceso',
            self::Finished => 'Terminado',
            self::Canceled => 'Cancelado'
        };
    }
}
