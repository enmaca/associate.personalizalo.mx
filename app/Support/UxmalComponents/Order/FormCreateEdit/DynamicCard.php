<?php

namespace App\Support\UxmalComponents\Order\FormCreateEdit;

use Illuminate\Support\Str;

class DynamicCard extends \Enmaca\LaravelUxmal\Abstract\Card
{

    public function build()
    {
        $this->BodyRow();

        $this->setBodyFieldRowClass('col-xxl-6 mb-3');

        $search_product_tomselect = \App\Support\UxmalComponents\Material\SelectByNameSkuDesc::Object(['options' => ['event-change-handler' => 'onChangeSelectedMaterialByNameSkuDesc']]);
        $this->BodyInput($search_product_tomselect);

        $search_labor_cost_tomselect = \App\Support\UxmalComponents\LaborCost\SelectByName::Object(['options' => ['event-change-handler' => 'onChangeSelectedLaborCostByName']]);
        $this->BodyInput($search_labor_cost_tomselect);

        $search_mfg_over_head_tomselect = \App\Support\UxmalComponents\MfgOverHead\SelectByName::Object();
        $this->BodyInput($search_mfg_over_head_tomselect);

        $this->BodyInput();

        $search_mfg_area_tomselect = \App\Support\UxmalComponents\MfgArea\SelectByName::Object();
        $this->BodyInput($search_mfg_area_tomselect);

        $search_mfg_devices_tomselect = \App\Support\UxmalComponents\MfgDevices\SelectByName::Object();
        $this->BodyInput($search_mfg_devices_tomselect);

        $footer = $this->Footer();
        $table = $footer->component('ui.table', ['options' => [
            'table.name' => 'orderProductDynamicDetails',
            'table.columns' => [
                'hashId' => [
                    'tbhContent' => 'hidden',
                    'type' => 'primaryKey'
                ],
                'related.name' => [
                    'tbhContent' => 'Material/Concepto',
                ],
                'quantity' => [
                    'tbhContent' => 'Cantidad',
                ],
                'cost' => [
                    'tbhContent' => 'Costo'
                ],
                'taxes' => [
                    'tbhContent' => 'Impuestos'
                ],
                'profit_margin' => [
                    'tbhContent' => 'Margen',
                    'handler' => \App\Support\UxmalComponents\OrderProductDynamicDetails\TbHandler\ProfitMargin::class
                ],
                'subtotal' => [
                    'tbhContent' => 'Subtotal'
                ],
                'createdby.name' => [
                    'tbhContent' => 'Creado'
                ]
            ],
            'table.data.livewire' => 'order-product-dynamic-details.table.tbody',
            'table.data.livewire.append-data' => [
                'values' => $this->attributes['values']
            ],
            'table.footer' => [
                'related.name' => [
                    'html' => '<span class="justify-end">Totales</span>'
                ],
                'cost' => [
                    'operation' => 'sum'
                ],
                'taxes' => [
                    'operation' => 'sum'
                ],
                'profit_margin' => [
                    'operation' => 'average'
                ],
                'subtotal' => [
                    'operation' => 'sum'
                ]
            ]
        ]]);
    }

}