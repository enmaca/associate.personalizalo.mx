<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use App\Support\Workshop\OrderProductDetails\TbHandler\MfgStatus as MfgStatusTbHandler;
use App\Support\Workshop\Products\SelectByName as SelectByNameProducts;
use Enmaca\LaravelUxmal\Abstract\CardBlock;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;

class ProductCard extends CardBlock
{

    /**
     * @throws \Exception
     */
    public function build(): void
    {
        $this->Body()->addRow();

        $this->setBodyFieldRowClass('col-xxl-6 mb-3');

        $this->Body()->addRow();

        $this->Body()->addElementInRow(
            element: SelectByNameProducts::Object([
                'values' => $this->GetValues()
            ]),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $deleteButton = new ButtonOptions(
            name: 'deleteOPrD'.bin2hex(random_bytes(3)),
            style: 'danger',
            type: 'icon',
            appendAttributes: [
                'data-workshop-oprd-delete' => true
            ],
            remixIcon: 'delete-bin-5-line'
        );
        $this->Footer()->addElementInRow(element: UxmalComponent::Make(type: 'ui.table', attributes: [
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
                        'tbhContent' => 'Precio'
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
                            $deleteButton->toArray()
                        ]
                    ]
                ],
                'table.data.livewire' => 'order-product-details.table.tbody',
                'table.data.livewire.append-data' => [
                    'values' => $this->GetValues()
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
        ]), row_options: new RowOptions(
            appendAttributes: [
                'class' => 'table-responsive'
            ]
        )
        );
    }

}