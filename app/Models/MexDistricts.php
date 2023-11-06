<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MexDistricts extends BaseModel
{
    use HasFactory;
    protected $table = 'mex_districts';
    protected $primaryKey = 'id';

    public function municipalities(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MexMunicipality::class, 'municipality_id', 'id');
    }

    public static function getZipCodeData($zip_code){
        return (new static())::where('postal_code', $zip_code)->get();
    }
}
