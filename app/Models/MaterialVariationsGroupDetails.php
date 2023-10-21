<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialVariationsGroupDetails extends BaseModel
{
    use HasFactory;
    protected $table = 'material_variations_group_detail';
    protected $primaryKey = 'id';

    public function mvg()
    {
        return $this->belongsTo(MaterialVariationsGroup::class, 'mvg_id');
    }
}
