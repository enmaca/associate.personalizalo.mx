<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialVariationsGroup extends BaseModel
{
    use HasFactory;
    protected $table = 'material_variations_group';
    protected $primaryKey = 'id';

    public function items()
    {
        return $this->hasMany(MaterialVariationsGroupDetails::class, 'mvg_id');
    }
}
