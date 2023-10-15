<?php

namespace App\Support\Uxmal\Order;

class ModalOrderSearchByClientMobile extends \Enmaca\LaravelUxmal\Abstract\Modal
{

    public function build()
    {
        $form = \Enmaca\LaravelUxmal\Uxmal::component('form');
        $form->componentsInDiv(['attributes' => [
            'class' => 'mb-3'
        ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'type' => 'text',
                    'label' => 'Celular',
                    'input.name' => 'customerMobile',
                    'input.placeholder' => '(+52) XXXXXXXXXX',
                    'input.required' => true,
                    'input.mask.cleave' => [
                        'type' => 'phone',
                        'phoneregioncode' => 'MX',
                        'prefix' => '+52 '
                    ] //TODO: CLEAVE INTEGRATION  https://github.com/nosir/cleave.js https://github.com/nosir/cleave.js/blob/master/doc/options.md
                ]
            ]]
        ]);


        $form->componentsInDiv(['attributes' => [
            'class' => 'mb-3'
        ]
        ], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'type' => 'text',
                    'label' => 'Nombre',
                    'input.name' => 'customerName',
                    'input.placeholder' => 'Ingresa el nombre del cliente',
                    'input.required' => true,
                ]
            ]]
        ]);

        $form->componentsInDiv(['attributes' => [
            'class' => 'mb-3'
        ]
        ], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'type' => 'text',
                    'label' => 'Apellido',
                    'input.name' => 'customerLastName',
                    'input.placeholder' => 'Ingresa el apellido del cliente',
                    'input.required' => true,
                ]
            ]]
        ]);

        $form->componentsInDiv(['attributes' => [
            'class' => 'mb-3'
        ]
        ], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'type' => 'text',
                    'label' => 'Correo Electrónico',
                    'input.name' => 'customerEmail',
                    'input.placeholder' => 'Ingresa el correo electrónico del cliente',
                    'input.required' => true
                ]
            ]]
        ]);

        $modal = \Enmaca\LaravelUxmal\Uxmal::component('ui.modal', [
            'options' => [
                'title' => 'Modal Title',
                'body' => $form,
                'saveBtn' => [
                    'onclick' => 'console.log("clicked")'
                ]
            ]
        ]);

        $this->_callBtn = match ($this->attributes['context']) {
            'search' => $modal->getShowButton([
                'options' => [
                    'label' => 'Buscar por Cliente'
                ]], 'array'),
            default => $modal->getShowButton([
                'options' => [
                    'label' => 'Crear Pedido'
                ]], 'array'),
        };

        $this->_content = $modal;

    }
}
