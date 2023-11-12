<?php

namespace App\Support\Workshop\AddressBook;

use Enmaca\LaravelUxmal\Abstract\FormBlock;
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

        $main_content = $this->Content();

        $this->NewContentRow();

        $this->ContentRow()->addRow(row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'bg-light border-bottom border-top p-3'
            ],
            content: '<h5>Dirección</h5>'
        ));

        $this->NewContentRow(row_options: new RowOptions(
            replaceAttributes: [
                'class' => 'row p-3 '
            ]
        ));

        $this->ContentRow()->addElementInRow(
            element: Checkbox::Options(
                new InputCheckboxOptions(
                    name: 'deliveryNeeded',
                    label: 'Se recogera en tienda',
                    style: 'primary',
                    type: 'switch',
                    value: '1',
                    direction: 'right'
                )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-12 col-md-6'
                ]
            ));

        $this->ContentRow()->addElementInRow(
            element: Checkbox::Options(new InputCheckboxOptions(
                name: 'recipientDataSameAsCustomer',
                label: 'Datos del Destinatario igual que el cliente?',
                style: 'primary',
                type: 'switch',
                value: '1',
                direction: 'right',
                checked: $this->GetValue(str::snake('recipientDataSameAsCustomer'))
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-12 col-md-6'
                ]
            ));

        /**
         * [
         * 'input.type' => 'checkbox',
         * 'checkbox.label.slot' => ,
         * 'checkbox.name' => ,
         * 'checkbox.value' => 1,
         * 'checkbox.checked' =>
         * ]
         */

        $this->NewContentRow(row_options: new RowOptions(
            name: 'recipientData',
            appendAttributes: [
                'data-workshop-recipient-data' => true
            ]
        ));

        $this->Input(options: new InputTextOptions(
            label: 'Nombre (Destinatario)',
            name: 'recipientName',
            value: $this->GetValue(str::snake('recipientName'))
        ));

        $this->Input(options: new InputTextOptions(
            label: 'Apellido (Destinatario)',
            name: 'recipientLastName',
            value: $this->GetValue(str::snake('recipientLastName'))
        ));

        $this->Input(options: new InputTextOptions(
            label: 'Celular (Destinatario)',
            name: 'recipientMobile',
            value: $this->GetValue(str::snake('recipientMobile'))
        ));

        $this->NewContentRow();

        $this->Input(new InputTextOptions(
            label: 'Calle y Número',
            name: 'address1',
            value: $this->GetValue('address_1'),
            required: true
        ), row_class: 'col-6');

        $this->Input(new InputTextOptions(
            label: 'Entre Calles',
            name: 'address2',
            value: $this->GetValue('address_2')
        ), row_class: 'col-6');

        $this->Input(new InputTextOptions(
            label: 'Código Postal',
            name: 'zipCode',
            value: $this->GetValue(str::snake('zipCode')),
            required: true
        ));

        $this->Input(options: new InputTextAreaOptions(
            label: 'Indicaciones de Entrega',
            name: 'directions',
            value: $this->GetValue(str::snake('deliveryInstructions')),
            rows: 3
        ), row_class: 'col-12 col-md-9');

        $row_selects = $this->NewContentRow();

        $row_selects->addElementInRow(
            element: SelectMexDistricts::Object(),
            row_options: new RowOptions(
                replaceAttributes: [
                    'wire:ignore' => true,
                    'class' => 'col-12 col-md-6'
                ])
        );

        $row_selects->addElementInRow(element: SelectMexMunicipalities::Object(),
            row_options: new RowOptions(
                replaceAttributes: [
                    'wire:ignore' => true,
                    'class' => 'col-12 col-md-6'
                ])
        );


        $row_selects->addElementInRow(element: SelectMexStates::Object(),
            row_options: new RowOptions(
                replaceAttributes: [
                    'wire:ignore' => true,
                    'class' => 'col-12 col-md-6'
                ])
        );

    }
}