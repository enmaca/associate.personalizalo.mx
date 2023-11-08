<?php

namespace App\Support\UxmalComponents\Order\EditScreen\MainContent;

use Illuminate\Support\Str;

class DynamicCard extends \Enmaca\LaravelUxmal\Abstract\Card
{

    public function build()
    {
        $this->BodyRow();

        $this->setBodyFieldRowClass('col-xxl-6 mb-3');

        $this->BodyInput(\App\Support\UxmalComponents\Material\SelectByNameSkuDesc::Object(['options' => ['event-change-handler' => 'onChangeSelectedMaterialByNameSkuDesc']]));

        $this->BodyInput(\App\Support\UxmalComponents\LaborCost\SelectByName::Object(['options' => ['event-change-handler' => 'onChangeSelectedLaborCostByName']]));

        $this->BodyInput(\App\Support\UxmalComponents\MfgOverHead\SelectByName::Object(['options' => ['event-change-handler' => 'onChangeSelectedMfgOverHeadByName']]));

        $footer = $this->Footer();

        $table = $footer->componentsInDiv(['options' => ['row.append-attributes' => ['class' => 'table-responsive']]], [[
            'path' => 'ui.table',
            'attributes' => [
                'options' => [
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
                        ],
                        'actions' => [
                            'tbhContent' => null,
                            'buttons' => [
                                [
                                    'button.type' => 'icon',
                                    'button.style' => 'danger',
                                    'button.onclick' => 'removeOPDD(this)',
                                    'button.name' => 'deleteOPPD',
                                    'button.remix-icon' => 'delete-bin-5-line'
                                ],
                            ]
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
                ]
            ]
        ]]);
    }

}