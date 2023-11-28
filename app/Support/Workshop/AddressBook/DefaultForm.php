<?php

namespace App\Support\Workshop\AddressBook;

use Enmaca\LaravelUxmal\Block\FormBlock;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Components\Form\Input\Checkbox;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputCheckboxOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextAreaOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Illuminate\Support\Str;

class DefaultForm extends FormBlock
{
    /**
     * @throws \Exception
     */
    public function build(): void
    {
        /**
         * Direccion
         * class="card-body bg-light border-bottom border-top bg-opacity-25"
         */
        $address = $this->GetValue('address');

        if( !is_array($address) )
            $address = [];

        $this->NewContentRow(row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'row bg-light border-bottom border-top p-3'
            ]
        ));

        $this->ContentRow()->addRow(row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'col-6'
            ],
            content: '<h5>Datos de Entrega</h5>'
        ));

        $this->ContentRow()->addElementInRow(
            element: Checkbox::Options(
                new InputCheckboxOptions(
                    name: 'shipmentStatus',
                    label: 'Se recogera en tienda',
                    style: 'primary',
                    type: 'switch',
                    value: 'not_needed',
                    direction: 'right',
                    checked: $this->GetValue(str::snake('shipmentStatus')) == 'not_needed'
                )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-6'
                ]
            ));

        $dataWorkshopShipmentDataExtraClass = '';
        if ($this->GetValue(str::snake('shipmentStatus')) == 'not_needed')
            $dataWorkshopShipmentDataExtraClass = ' d-none';

        $dataWorkshopShipmentDataRow = $this->NewContentRow(row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'row mt-3' . $dataWorkshopShipmentDataExtraClass,
                'data-workshop-shipment-data' => true
            ]
        ));

        $dataWorkshopShipmentDataRow->addElementInRow(
            element: Checkbox::Options(new InputCheckboxOptions(
                name: 'recipientDataSameAsCustomer',
                label: 'Datos del Destinatario igual que el cliente?',
                style: 'primary',
                type: 'switch',
                value: '1',
                direction: 'right',
                checked: $address[str::snake('recipientDataSameAsCustomer')] ?? false
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-12'
                ]
            ));

        $dataWorkShopShipmentDataRecipientData = $dataWorkshopShipmentDataRow->addRow(row_options: new RowOptions(
            name: 'recipientData',
            appendAttributes: [
                'data-workshop-recipient-data' => true,
                'class' => 'row'
            ]
        ));

        $dataWorkShopShipmentDataRecipientData->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Nombre (Destinatario)',
                name: 'recipientName',
                value: $address[str::snake('recipientName')]  ?? ''
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-3 col-md-6'
                ]
            )
        );

        $dataWorkShopShipmentDataRecipientData->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Apellido (Destinatario)',
                name: 'recipientLastName',
                value: $address[str::snake('recipientLastName')] ?? ''
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-3 col-md-6'
                ]
            )
        );

        $dataWorkShopShipmentDataRecipientData->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Celular (Destinatario)',
                name: 'recipientMobile',
                value: $address[str::snake('recipientMobile')] ?? ''
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-3 col-md-6'
                ]
            )
        );

        $dataWorkshopShipmentDataRow->addRow();

        $dataWorkshopShipmentDataRow->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Calle y Número',
                name: 'address1',
                value: $address['address_1'] ?? '',
                required: true
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-6'
                ]
            )
        );

        $dataWorkshopShipmentDataRow->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Entre Calles',
                name: 'address2',
                value: $address['address_2'] ?? ''
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-6'
                ]
            )
        );

        $dataWorkshopShipmentDataRow->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Código Postal',
                name: 'zipCode',
                value: $address[str::snake('zipCode')] ?? '',
                required: true
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-3 col-md-6'
                ]
            )
        );

        $dataWorkshopShipmentDataRow->addElementInRow(
            element: Input::Options(new InputTextAreaOptions(
                label: 'Indicaciones de Entrega',
                name: 'directions',
                value: $address['directions'] ?? '',
                rows: 3
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-12 col-md-9'
                ]
            )
        );

        $row_selects = $dataWorkshopShipmentDataRow->addRow();

        $row_selects->addElementInRow(element: SelectMexDistricts::Object(values: $address ?? []),
            row_options: new RowOptions(
                replaceAttributes: [
                    'wire:ignore' => true,
                    'class' => 'col-12 col-md-6'
                ])
        );

        $row_selects->addElementInRow(element: SelectMexMunicipalities::Object(values: $address ?? []),
            row_options: new RowOptions(
                replaceAttributes: [
                    'wire:ignore' => true,
                    'class' => 'col-12 col-md-6'
                ])
        );


        $row_selects->addElementInRow(element: SelectMexStates::Object(values: $address ?? []),
            row_options: new RowOptions(
                replaceAttributes: [
                    'wire:ignore' => true,
                    'class' => 'col-12 col-md-6'
                ])
        );

    }
}