<?php

namespace App\Support\UxmalComponents\Order\FormCreateEdit;

use Enmaca\LaravelUxmal\Uxmal;
use Illuminate\Support\Str;

class ClientCard extends \Enmaca\LaravelUxmal\Abstract\Card
{

    public function build(){

        $this->attributes['options']['customer.card.readonly'] ??= true;


        
        $this->BodyRow();

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Celular',
            'input.name' => 'customerMobile',
            'input.placeholder' => '(+52) XXXXXXXXXX',
            'input.value' => $this->attributes['values'][str::snake('customerMobile')] ?? '',
            'input.required' => true,
            'input.readonly' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Nombre',
            'input.name' => 'customerName',
            'input.placeholder' => 'Ingresa el nombre del cliente',
            'input.value' => $this->attributes['values'][str::snake('customerName')] ?? '',
            'input.required' => true,
            'input.readonly' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Apellido',
            'input.name' => 'customerLastName',
            'input.placeholder' => 'Ingresa el apellido del cliente',
            'input.value' => $this->attributes['values'][str::snake('customerLastName')] ?? '',
            'input.required' => true,
            'input.readonly' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Correo Electrónico',
            'input.name' => 'customerEmail',
            'input.placeholder' => 'Ingresa el correo electrónico del cliente',
            'input.value' => $this->attributes['values'][str::snake('customerEmail')] ?? '',
            'input.required' => true,
            'input.readonly' => true
        ]);

       $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Fecha de Entrega',
            'input.name' => 'deliveryDate',
            'input.value' => $this->attributes['values'][str::snake('deliveryDate')] ?? '',
            'input.readonly' => $this->attributes['options']['customer.card.readonly'],
            'input.required' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Indicaciones de Entrega',
            'input.name' => 'deliveryInstructions',
            'input.placeholder' => 'Instrucciones de entrega',
            'input.value' => $this->attributes['values'][str::snake('deliveryInstructions')] ?? '',
            'input.readonly' => $this->attributes['options']['customer.card.readonly'],
            'input.required' => true
        ]);
    }

}