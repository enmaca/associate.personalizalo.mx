<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use App\Support\Workshop\LaborCost\SelectByName as SelectByNameLaborCost;
use App\Support\Workshop\Material\SelectByNameSkuDesc as SelectByNameSkuDescMaterial;
use App\Support\Workshop\MfgArea\SelectByName as SelectByNameMfgArea;
use App\Support\Workshop\MfgDevices\SelectByName as SelectByNameMfgDevices;
use App\Support\Workshop\MfgOverHead\SelectByName as SelectByNameMfgOverHead;
use App\Support\Workshop\OrderProductDynamicDetails\SelectDynamicProducts;
use App\Support\Workshop\OrderProductDynamicDetails\TbHandler\ProfitMargin as ProfitMarginTbHandler;
use Enmaca\LaravelUxmal\Abstract\CardBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Components\Ui\Dropzone;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputCheckboxOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputHiddenOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextAreaOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\DropzoneOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;
use OpenSpout\Common\Entity\Row;

class DynamicCard extends CardBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $this->NewBodyRow(row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'row align-items-end'
            ]
        ));

        $this->BodyRow()->addElementInRow(
            element: SelectDynamicProducts::Object(
                values: $this->GetValues()
            ),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-9 mb-3'
                ]
            ));

        $this->BodyRow()->addElementInRow(
            element: Button::Options(new ButtonOptions(
                label: 'Crear Nuevo Producto',
                name: 'createNewDynamicProductButton',
                style: 'warning',
                width: 'w-sm'
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-3 mb-3'
                ]
            ));

        $this->NewBodyRow(row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'row align-items-end'
            ]
        ));

        $this->BodyRow()->addElementInRow(
            element: SelectByNameSkuDescMaterial::Object(
                values: $this->GetValues()
            ),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->BodyRow()->addElementInRow(
            element: SelectByNameLaborCost::Object(
                values: $this->GetValues()
            ),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->BodyRow()->addElementInRow(
            element: SelectByNameMfgOverHead::Object(
                values: $this->GetValues()
            ),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->NewBodyRow();

        $this->BodyRow()->addElementInRow(element: Input::Options(new InputCheckboxOptions(
            name: 'mfgMediaIdNeeded',
            label: 'Necesita Diseño',
            type: 'switch',
            direction: 'right',
            checked: false
        )), row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'col-3 mb-3'
            ]
        ));

        $this->NewBodyRow(row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'row align-items-end d-none',
                'workshop-opd-mfg-media-instructions' => true
            ]
        ));

        $this->BodyRow()->addElementInRow(
            element: Dropzone::Options(new DropzoneOptions(
                name: 'dropzone',
                url: '#',
                enablePreview: true,
                removeLabelButton: 'Borrar',
                method: 'POST',
                uploadMessage: 'Archivos de referencia por el cliente maximo (1MB).',
                maxFilesize: '1MB',
                dictFileTooBig: 'El archivo es demasiado grande ({{filesize}}MB). Tamaño máximo de archivo: {{maxFilesize}}MB.',
                acceptedFiles: 'image/*',
                dictInvalidFileType: 'No se puede subir este tipo de archivo.'
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-12 mb-3'
                ]
            ));

        $buttonSaveInstructions = Button::Options(new ButtonOptions(
            label: 'Guardar Instrucciones',
            name: 'updateMfgMediaInstructionsButton',
            style: 'warning',
            size: 'sm',
            width: 'w-xs',
            appendAttributes: [
                'class' => 'ms-4',
            ]
        ));

        $this->BodyRow()->addElementInRow(
            element: Input::Options(new InputTextAreaOptions(
                    label: 'Instrucciones de diseño'.$buttonSaveInstructions->toHtml(),
                    name: 'customerInstructions',
                    placeholder: 'Instrucciones de diseño',
                )
            ),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-12 mb-3'
                ]
            ));

        $this->NewBodyRow();

        $this->BodyRow()->addElementInRow(
            element: Input::Options(new InputCheckboxOptions(
                name: 'mfgStatus',
                label: 'Necesita Fabricación',
                type: 'switch',
                direction: 'right',
                checked: false
            )), row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'col-12'
            ]
        ));

        $this->NewBodyRow(row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'row align-items-end d-none',
                'workshop-opd-mfg-status' => true
            ]
        ));

        $this->BodyRow()->addElementInRow(
            element: SelectByNameMfgArea::Object(
                values: $this->GetValues()
            ),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->BodyRow()->addElementInRow(
            element: SelectByNameMfgDevices::Object(
                values: $this->GetValues()
            ),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $footer = $this->Footer()->addRow(new RowOptions(
            replaceAttributes: [
                'class' => 'row',
                'workshop-order-product-dynamic-details-description' => true
            ],
            content: '<div class="col-12"><h5 id="orderDynamicDetailsDescriptionId"></h5></div>'
        ));

        $deleteButton = new ButtonOptions(
            name: 'deleteOPDD'.bin2hex(random_bytes(3)),
            style: 'danger',
            type: 'icon',
            appendAttributes: [
                'data-workshop-opd-delete' => true
            ],
            remixIcon: 'delete-bin-5-line'
        );
        $footer->addElementInRow(element: UxmalComponent::Make(type: 'ui.table', attributes: [
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
                    'price' => [
                        'tbhContent' => 'Precio'
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
                            $deleteButton->toArray()
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
                    'taxes' => [
                        'operation' => 'sum'
                    ],
                    'profit_margin' => [
                        'operation' => 'average'
                    ],
                    'subtotal' => [
                        'operation' => 'sum'
                    ],
                    'price' => [
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