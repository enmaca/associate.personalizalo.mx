<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use App\Support\Workshop\OrderProductDetails\TbHandler\MfgStatus as MfgStatusTbHandler;
use App\Support\Workshop\Products\SelectByName as SelectByNameProducts;
use Enmaca\LaravelUxmal\Abstract\CardBlock;
use Enmaca\LaravelUxmal\UxmalComponent;

class ProductCard extends CardBlock
{

    /**
     * @throws \Exception
     */
    public function build(): void
    {
        $this->BodyRow();

        $this->setBodyFieldRowClass('col-xxl-6 mb-3');

        $this->BodyRow();

        $this->BodyInput(SelectByNameProducts::Object([
            'values' => $this->attributes['values']
        ]));

        $table = $this->Footer()->addElementInRow(element: UxmalComponent::Make(type: 'ui.table', attributes: [
            'options' => [
                'table.name' => 'orderProductDetails',
                'table.columns' => [
                    'hashId' => [
                        'tbhContent' => 'hidden',
                        'type' => 'primaryKey'
                    ],
                    'product.name' => [
                        'tbhContent' => 'Nombre',
                    ],
                    'mfg_data' => [
                        'tbhContent' => 'Datos de Manufactura',
                        'type' => 'mixed',
                        'handler' => MfgStatusTbHandler::class
                    ],
                    'quantity' => [
                        'tbhContent' => 'Cantidad',
                    ],
                    'price' => [
                        'tbhContent' => 'Costo'
                    ],
                    'taxes' => [
                        'tbhContent' => 'Impuestos'
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
                                'button.name' => 'deleteOPD',
                                'button.onclick' => 'removeOPD(this)',
                                'button.remix-icon' => 'delete-bin-5-line'
                            ],
                        ]
                    ]
                ],
                'table.data.livewire' => 'order-product-details.table.tbody',
                'table.data.livewire.append-data' => [
                    'values' => $this->attributes['values']
                ],
                'table.footer' => [
                    'mfg_data' => [
                        'html' => '<span class="justify-end">Totales</span>'
                    ],
                    'price' => [
                        'operation' => 'sum'
                    ],
                    'taxes' => [
                        'operation' => 'sum'
                    ],
                    'subtotal' => [
                        'operation' => 'sum'
                    ]
                ]
            ]
        ]), row_options: ['row.append-attributes' => ['class' => 'table-responsive']]);
    }

}