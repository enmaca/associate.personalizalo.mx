<?php

namespace App\Support\Uxmal\Order;

use Enmaca\LaravelUxmal\Uxmal;
use Illuminate\Support\Str;

class FormCreate extends \Enmaca\LaravelUxmal\Abstract\Form
{
    public function build()
    {

        //dump($this->attributes['values']);
        $this->Row();

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Celular',
            'input.name' => 'customerMobile',
            'input.placeholder' => '(+52) XXXXXXXXXX',
            'input.value' => $this->attributes['values'][str::snake('customerMobile')] ?? '',
            'input.required' => true
        ]);

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Nombre',
            'input.name' => 'customerName',
            'input.placeholder' => 'Ingresa el nombre del cliente',
            'input.value' => $this->attributes['values'][str::snake('customerName')] ?? '',
            'input.required' => true,
        ]);

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Apellido',
            'input.name' => 'customerLastName',
            'input.placeholder' => 'Ingresa el apellido del cliente',
            'input.value' => $this->attributes['values'][str::snake('customerLastName')] ?? '',
            'input.required' => true,
        ]);

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Correo Electrónico',
            'input.name' => 'customerEmail',
            'input.placeholder' => 'Ingresa el correo electrónico del cliente',
            'input.value' => $this->attributes['values'][str::snake('customerEmail')] ?? '',
            'input.required' => true
        ]);

        $card_products_row = $this->Row();



        $search_product_tomselect =  \App\Support\Uxmal\Products\SelectByName::Object();

        $card_products_content = new \Enmaca\LaravelUxmal\Uxmal();

        $card_products_content->componentsInDiv([
            'attributes' => [
                'class' => 'col-xxl-6 col-md-12'
            ]], $search_product_tomselect);

        $card_products = $card_products_row->component('ui.card', [
            'options' => [
                'card.header' => 'Productos ',
                'card.body' => $card_products_content,
                'card.footer' => '',
            ]
        ]);
    }
}

