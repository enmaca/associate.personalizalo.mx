<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfgOverhead extends BaseModel
{
    use HasFactory;
    protected $table = 'mfg_overhead';
    protected $primaryKey = 'id';

    public function opdd(){
        return $this->morphMany(OrderProductDynamicDetails::class, 'related');
    }
    public function taxes(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Tax::class, 'taxes_details', 'reference_id', 'catalog_taxes_id')
            ->wherePivot('reference_type', 'mfg_overhead');
    }
}
