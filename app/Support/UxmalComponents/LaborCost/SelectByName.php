<?php

namespace App\Support\UxmalComponents\LaborCost;

use App\Models\LaborCost;

class SelectByName extends \App\Support\UxmalComponents\BaseTomSelect
{
    protected $Model = LaborCost::class;

    public function build(): void
    {
        $aggregate = [];

        if (isset($this->attributes['options']['event-change-handler']))
            $aggregate['tomselect.event-change-handler'] = $this->attributes['options']['event-change-handler'];

        $this->Options = [
                'tomselect.label' => 'Mano de Obra',
                'tomselect.name' => 'laborCostSelected',
                'tomselect.placeholder' => 'Seleccionar...',
                'tomselect.load-url' => '/labor_costs/search_tomselect?context=by_name',
                'tomselect.allow-empty-option' => true
            ] + $aggregate;

        parent::build();
    }

}