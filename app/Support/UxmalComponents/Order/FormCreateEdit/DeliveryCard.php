<?php

namespace App\Support\UxmalComponents\Order\FormCreateEdit;

use Illuminate\Support\Str;

class DeliveryCard extends \Enmaca\LaravelUxmal\Abstract\Card
{

    public function build()
    {

        $this->BodyRow();

        $this->attributes['options']['delivery.card.readonly'] ??= true;

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Fecha de Entrega',
            'input.name' => 'deliveryDate',
            'input.value' => $this->attributes['values'][str::snake('deliveryDate')] ?? '',
            'input.readonly' => $this->attributes['options']['delivery.card.readonly'],
            'input.required' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Indicaciones de Entrega',
            'input.name' => 'deliveryInstructions',
            'input.placeholder' => 'Instrucciones de entrega',
            'input.value' => $this->attributes['values'][str::snake('deliveryInstructions')] ?? '',
            'input.readonly' => $this->attributes['options']['delivery.card.readonly'],
            'input.required' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Apellido',
            'input.name' => 'customerLastName',
            'input.placeholder' => 'Ingresa el apellido del cliente',
            'input.readonly' => $this->attributes['options']['delivery.card.readonly'],
            'input.required' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Correo Electrónico',
            'input.name' => 'customerEmail',
            'input.placeholder' => 'Ingresa el correo electrónico del cliente',
            'input.readonly' => $this->attributes['options']['delivery.card.readonly'],
            'input.required' => true
        ]);
    }

}