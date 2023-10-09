<?php

namespace App\Enums;

enum UnitOfMeasureCategoryEnum: string
{
    case Unit = 'unit';
    case Weight = 'weight';
    case WorkingTime = 'working_time';
    case LengthOrDistance = 'length/distance';
    case Surface = 'surface';
    case Volume = 'volume';

    public function label(): string
    {
        return match ($this) {
            self::Unit => 'Unidad',
            self::Weight => 'Peso',
            self::WorkingTime => 'Tiempo de trabajo',
            self::LengthOrDistance => 'Longitud/distancia',
            self::Surface => 'Superficie',
            self::Volume => 'Volumen',
        };
    }
}
