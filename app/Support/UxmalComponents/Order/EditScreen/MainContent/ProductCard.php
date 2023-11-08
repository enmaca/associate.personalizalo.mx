<?php

namespace App\Support\UxmalComponents\Order\EditScreen\MainContent;

use Illuminate\Support\Str;

class ProductCard extends \Enmaca\LaravelUxmal\Abstract\Card
{

    public function build(): void
    {
        $this->BodyRow();

        $this->setBodyFieldRowClass('col-xxl-6 mb-3');

        $search_product_tomselect =  \App\Support\UxmalComponents\Products\SelectByName::Object([
            'values' => $this->attributes['values']
        ]);
        $this->BodyRow();

        $this->BodyInput($search_product_tomselect);

        $footer = $this->Footer();

        $table = $footer->componentsInDiv(['options' => ['row.append-attributes' => ['class' => 'table-responsive']]], [[
            'path' => 'ui.table',
            'attributes' => [
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
                            'handler' => \App\Support\UxmalComponents\OrderProductDetails\TbHandler\MfgStatus::class
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
            ]
        ]]);
    }

}