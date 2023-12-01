<?php
namespace App\Support\Enums;

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
            self::Incomplete => '<span class="badge text-danger bg-danger-subtle">Incompleto</span>',
            self::New => '<span class="badge text-primary bg-primary-subtle">Nuevo</span>',
            self::Processing => '<span class="badge text-warning bg-warning-subtle">En proceso</span>',
            self::Finished => '<span class="badge text-success bg-success-subtle">Terminado</span>',
            self::Canceled => '<span class="badge text-dark bg-dark-subtle">Cancelado</span>'
        };
    }
}