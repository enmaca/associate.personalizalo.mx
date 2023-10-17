<?php

namespace App\Support\Uxmal\Customer;

class ModalSearchByMobile extends \Enmaca\LaravelUxmal\Abstract\Modal
{

    public function build()
    {
        $form = \Enmaca\LaravelUxmal\Uxmal::component('form', [
            'options' => [
                'id' => 'NewOrderFrom',
                'action' => '/orders',
                'method' => 'POST'
            ]
        ]);

        $form->addElement(SelectByNameMobileEmail::Object());
/*
        $form->component('livewire', [
            'path' => 'input.modal-search-by-mobile.customer-mobile'
        ]);
*/
        /*

        $form->component('form.input.hidden', [
            'options' => [
                'name' => 'customerId',
                'value' => 'new'
            ]
        ]);
        */

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
                'title' => 'Buscar/Crear Cliente',
                'body' => $form,
                'saveBtn' => [
                    'label' => 'Crear Pedido',
                    'onclick' => 'submitNewOrderFrom()'
                ]
            ]
        ]);

        switch($this->attributes['context']){
            case 'createclient':
                $this->_callBtn = $modal->getShowButton([
                    'options' => [
                        'label' => 'Agregar Cliente'
                    ]], 'object');
                break;
            case 'createorder':
                $this->_callBtn =  $modal->getShowButton([
                    'options' => [
                        'label' => 'Crear Pedido'
                    ]], 'object');
                break;
            default:
                $this->_callBtn =  $modal->getShowButton([
                    'options' => [
                        'label' => 'Mostrar'
                    ]], 'object');
                break;
        }

        $this->_content = $modal;

    }
}
