<?php

namespace App\Models;

use App\Enums\UnitOfMeasureCategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends Model
{
    use HasFactory;

    protected $table = 'catalog_unit_of_measure';

    public function getUomCategoryLabelAttribute()
    {
        $unit = UnitOfMeasureCategoryEnum::tryFrom($this->uom_category);

        return $unit ? $unit->label() : 'Unknown ['.$this->uom_category.']';
    }
}
