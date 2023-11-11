<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaravelIdea\Helper\App\Models\_IH_MexDistricts_C;

class MexDistricts extends BaseModel
{
    use HasFactory;
    protected $table = 'mex_districts';
    protected $primaryKey = 'id';

    public function municipalities(): BelongsTo
    {
        return $this->belongsTo(MexMunicipalities::class, 'municipality_id', 'id');
    }

    public static function getZipCodeData($zip_code)
    {
        return (new static())::where('postal_code', $zip_code)->get();
    }
}
