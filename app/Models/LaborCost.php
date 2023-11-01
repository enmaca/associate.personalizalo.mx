<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class LaborCost extends BaseModel
{
    use HasFactory;

    protected $table = 'catalog_labor_costs';


    public function opdd(){
        return $this->morphMany(OrderProductDynamicDetails::class, 'related');
    }

    public function mfg_cost(){
        return $this->morphMany(ManufacturingCost::class, 'related');
    }

    public function calculateCosts($quantity){
        $totalTax = $this->taxes->sum('value');
        $costByMinute = $this->cost_by_hour / 60;
        if( $quantity < $this->min_fraction_cost_in_minutes )
            $cost = $this->min_fraction_cost_in_minutes * $costByMinute;
        else
            $cost = $quantity * $costByMinute;

        $taxes =  $totalTax * $cost;
        return [
            'uom' => $costByMinute,
            'cost' => $cost,
            'taxes' => $taxes,
            'profit_margin' => 0,
            'subtotal' => ($cost + $taxes)
        ];

    }

    public function taxes(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Tax::class, 'taxes_details', 'reference_id', 'catalog_taxes_id')
            ->wherePivot('reference_type', 'catalog_labor_costs');
    }
}
