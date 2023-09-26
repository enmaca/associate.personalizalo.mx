<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfgDevice extends Model
{
    use HasFactory;

    protected $table = 'mfg_devices';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mfg_area_id',
        'name',
    ];

    public function mfg_area(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(MfgArea::class, 'mfg_area_id', 'id');
    }
}
