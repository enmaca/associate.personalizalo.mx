<?php

namespace App\Support\UxmalComponents\AddressBook;

use Enmaca\LaravelUxmal\Abstract\Form;
use Illuminate\Support\Str;

class DefaultForm extends Form
{
    public function build(): void
    {

        $this->Row(true, [
            'row.name' => 'recipientData',
            'row.append-attributes' => [
                'data-workshop-recipient-data' => true
            ]
        ]);

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

        $this->Row();

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Calle y Número',
            'input.name' => 'address1',
            'input.value' => isset($this->attributes['values'][str::snake('address1')]) ? $this->attributes['values'][str::snake('address1')] : ''
        ], 'col-6');

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

        $this->addElement(SelectMexDistricts::Object());

        $this->addElement(SelectMexMunicipalities::Object());

        $this->addElement(SelectMexStates::Object());

    }
}