<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfgArea extends BaseModel
{
    use HasFactory;

    protected $table = 'mfg_areas';

    protected $fillable = [
        'name',
    ];

    public function devices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MfgDevice::class, 'mfg_area_id', 'id');
    }
}
