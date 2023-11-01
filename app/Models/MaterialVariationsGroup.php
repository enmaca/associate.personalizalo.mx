<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialVariationsGroup extends BaseModel
{
    use HasFactory;
    protected $table = 'material_variations_group';
    protected $primaryKey = 'id';

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MaterialVariationsGroupDetails::class, 'mvg_id');
    }

    public function mfg_cost(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(ManufacturingCost::class, 'related');
    }
}
