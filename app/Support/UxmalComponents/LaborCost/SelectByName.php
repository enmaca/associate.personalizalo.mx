<?php

namespace App\Support\UxmalComponents\LaborCost;

use App\Models\LaborCost;
use Exception;

class SelectByName extends \App\Support\UxmalComponents\BaseTomSelect
{
    protected string $Model = LaborCost::class;

    /**
     * @return void
     * @throws Exception
     */
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