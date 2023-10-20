<?php

namespace App\Support\UxmalComponents\LaborCost;

use App\Models\LaborCost;

class SelectByName extends \App\Support\UxmalComponents\BaseTomSelect
{
    protected $Model = LaborCost::class;

    protected $Options = [
        'tomselect.name' => 'laborCostSelected',
        'tomselect.placeholder' => 'Costos de manufactura...',
        'tomselect.load-url' => '/labor_costs/search_tomselect?context=by_name',
        'tomselect.allow-empty-option' => true,
        'tomselect.event-change-handler' => 'onChangeSelectedLaborCostByName'
    ];

}