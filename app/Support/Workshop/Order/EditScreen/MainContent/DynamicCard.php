<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use App\Support\Workshop\LaborCost\SelectByName as SelectByNameLaborCost;
use App\Support\Workshop\Material\SelectByNameSkuDesc as SelectByNameSkuDescMaterial;
use App\Support\Workshop\MfgOverHead\SelectByName as SelectByNameMfgOverHead;
use App\Support\Workshop\OrderProductDynamicDetails\TbHandler\ProfitMargin as ProfitMarginTbHandler;
use Enmaca\LaravelUxmal\Abstract\CardBlock;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class DynamicCard extends CardBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $this->Body()->addRow();

        $this->setBodyFieldRowClass('col-xxl-6 mb-3');

        $this->Body()->addElementInRow(
            element: SelectByNameSkuDescMaterial::Object(['options' => ['event-change-handler' => 'onChangeSelectedMaterialByNameSkuDesc']]),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->Body()->addElementInRow(
            element: SelectByNameLaborCost::Object(['options' => ['event-change-handler' => 'onChangeSelectedLaborCostByName']]),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->Body()->addElementInRow(
            element:SelectByNameMfgOverHead::Object(['options' => ['event-change-handler' => 'onChangeSelectedMfgOverHeadByName']]),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->Footer()->addElementInRow(element: UxmalComponent::Make(type: 'ui.table', attributes: [
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
                        'handler' => ProfitMarginTbHandler::class
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
                    'values' => $this->GetValues()
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
        ]),
            row_options: new RowOptions(
                appendAttributes: [
                    'class' => 'table-responsive'
                ]
            )
        );
    }

}