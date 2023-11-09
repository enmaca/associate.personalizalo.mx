<?php

namespace App\Support\UxmalComponents\AddressBook;

use Enmaca\LaravelUxmal\Abstract\FormBlock;
use Enmaca\LaravelUxmal\Components\Ui\Row;
use Illuminate\Support\Str;

class DefaultForm extends FormBlock
{
    public function build(): void
    {
        $this->Input([
            'input.type' => 'checkbox',
            'checkbox.label' => 'Datos del Destinatario igual que el cliente?',
            'checkbox.name' => 'recipientDataSameAsCustomer',
            'checkbox.value' => 1,
            'checkbox.checked' => isset($this->attributes['values'][str::snake('recipientDataSameAsCustomer')]) && $this->attributes['values'][str::snake('recipientDataSameAsCustomer')] == 1
        ], 'col-12');


        $this->ContentAddRow(row_options: [
            'row.name' => 'recipientData',
            'row.append-attributes' => [
                'data-workshop-recipient-data' => true
            ]]);

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Nombre (Destinatario)',
            'input.name' => 'recipientName',
            'input.value' => isset($this->attributes['values'][str::snake('recipientName')]) ? $this->attributes['values'][str::snake('recipientName')] : ''
        ]);

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Apellido (Destinatario)',
            'input.name' => 'recipientLastName',
            'input.value' => isset($this->attributes['values'][str::snake('recipientLastName')]) ? $this->attributes['values'][str::snake('recipientLastName')] : ''
        ]);

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Celular (Destinatario)',
            'input.name' => 'recipientMobile',
            'input.value' => isset($this->attributes['values'][str::snake('recipientMobile')]) ? $this->attributes['values'][str::snake('recipientMobile')] : ''
        ]);

        $this->ContentAddRow();

        $this->Input(
            options : [
            'input.type' => 'text',
            'input.label' => 'Calle y Número',
            'input.name' => 'address1',
            'input.value' => isset($this->attributes['values'][str::snake('address1')]) ? $this->attributes['values'][str::snake('address1')] : ''
        ], row_class: 'col-6');

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Entre Calles',
            'input.name' => 'address2',
            'input.value' => isset($this->attributes['values'][str::snake('address2')]) ? $this->attributes['values'][str::snake('address2')] : ''
        ], 'col-6');

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Código Postal',
            'input.name' => 'zipCode',
            'input.value' => isset($this->attributes['values'][str::snake('zipCode')]) ? $this->attributes['values'][str::snake('zipCode')] : ''
        ]);

        $this->ContentAddRowInput(element : SelectMexDistricts::Object());
        $this->ContentAddRowInput(element : SelectMexMunicipalities::Object());
        $this->ContentAddRowInput(element : SelectMexStates::Object());
    }
}