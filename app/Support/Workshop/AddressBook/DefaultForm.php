<?php

namespace App\Support\Workshop\AddressBook;

use Enmaca\LaravelUxmal\Abstract\FormBlock;
use Enmaca\LaravelUxmal\Components\Form\Input\Checkbox as CheckboxInput;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextAreaOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
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
        $this->ContentAddRow(row_options: [
            'row.slot' => '<h5>Dirección</h5>',
            'row.append-attributes' => [
                'class' => 'bg-light border-bottom border-top p-3'
            ]
        ]);

        $this->ContentAddRow();

        $this->ContentAddElement(element: CheckboxInput::Options([
            'input.type' => 'checkbox',
            'checkbox.label' => 'Datos del Destinatario igual que el cliente?',
            'checkbox.name' => 'recipientDataSameAsCustomer',
            'checkbox.value' => 1,
            'checkbox.checked' => $this->GetValue(str::snake('recipientDataSameAsCustomer'))
        ]));

        $this->ContentAddRow(row_options: [
            'row.name' => 'recipientData',
            'row.append-attributes' => [
                'data-workshop-recipient-data' => true
            ]]);

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

        $this->ContentAddRow();

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

        $this->Input( options: new InputTextAreaOptions(
            label: 'Indicaciones de Entrega',
            name: 'directions',
            value: $this->GetValue(str::snake('deliveryInstructions')),
            rows: 3
        ), row_class: 'col-12 col-md-9');

        $row_selects = $this->ContentAddRow();
        $row_selects->addElementInRow(element: SelectMexDistricts::Object(), row_options: [
            'row.replace-attributes' => [
                'wire:ignore' => true,
                'class' => 'col-12 col-md-6'
            ]
        ]);

        $row_selects->addElementInRow(element: SelectMexMunicipalities::Object(), row_options: [
            'row.replace-attributes' => [
                'wire:ignore' => true,
                'class' => 'col-12 col-md-6'
            ]
        ]);

        $row_selects->addElementInRow(element: SelectMexStates::Object(), row_options: [
            'row.replace-attributes' => [
                'wire:ignore' => true,
                'class' => 'col-12 col-md-6'
            ]
        ]);
    }
}