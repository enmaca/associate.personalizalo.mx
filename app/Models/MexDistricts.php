<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MexDistricts extends Model
{
    use HasFactory;
    protected $table = 'mex_districts';
    protected $primaryKey = 'id';

    public function municipalities(){
        return $this->belongsTo(MexMunicipalities::class, 'municipality_id');
    }

    public static function getZipCodeData($zip_code){
        return (new static())::where('postal_code', $zip_code)->get();
    }
}
