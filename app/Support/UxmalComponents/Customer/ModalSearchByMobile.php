<?php

namespace App\Support\UxmalComponents\Customer;

use App\Support\UxmalComponents\Customer\SelectByNameMobileEmail;

class ModalSearchByMobile extends \Enmaca\LaravelUxmal\Abstract\ModalBlock
{

    public function build()
    {
        $form = \Enmaca\LaravelUxmal\UxmalComponent::Make('form', [
            'options' => [
                'form.id' => 'NewOrderFrom',
                'form.action' => '/orders',
                'form.method' => 'POST'
            ]
        ]);

        $main_row = $form->component('ui.row', ['options' => [ 'row.append-attributes' => [ 'class' => 'gy-4'] ]]);

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], SelectByNameMobileEmail::Object());
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

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'text',
                    'input.label' => 'Celular',
                    'input.name' => 'customerMobile',
                    'input.placeholder' => '(+52) XXXXXXXXXX',
                    'input.required' => true,
                    'input.mask.cleave.type' => 'phone',
                    'input.mask.cleave.phone.region-code' => 'MX',
                    'input.mask.cleave.prefix' => '+52 '
                ] //TODO: CLEAVE INTEGRATION  https://github.com/nosir/cleave.js https://github.com/nosir/cleave.js/blob/master/doc/options.md
            ]]
        ]);

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'text',
                    'input.label' => 'Nombre',
                    'input.name' => 'customerName',
                    'input.placeholder' => 'Ingresa el nombre del cliente',
                    'input.required' => true,
                ]
            ]]
        ]);

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'text',
                    'input.label' => 'Apellido',
                    'input.name' => 'customerLastName',
                    'input.placeholder' => 'Ingresa el apellido del cliente',
                    'input.required' => true,
                ]
            ]]
        ]);

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'text',
                    'input.label' => 'Correo Electrónico',
                    'input.name' => 'customerEmail',
                    'input.placeholder' => 'Ingresa el correo electrónico del cliente',
                    'input.required' => true
                ]
            ]]
        ]);

        $modal = \Enmaca\LaravelUxmal\UxmalComponent::Make('ui.modal', [
            'options' => [
                'modal.name' => 'customerSearchByMobile',
                'modal.title' => 'Buscar/Crear Cliente',
                'modal.body' => $form,
                'modal.saveBtn.label' => 'Crear Pedido',
                'modal.saveBtn.onclick' => 'submitNewOrderFrom()'
            ]
        ]);

        switch ($this->GetContext()) {
            case 'createclient':
                $this->_callBtn = $modal->getShowButton([
                    'options' => [
                        'button.name' => 'clientAdd',
                        'button.label' => 'Agregar Cliente'
                    ]], 'object');
                break;
            case 'createorder':
                $this->_callBtn = $modal->getShowButton([
                    'options' => [
                        'button.name' => 'orderCreate',
                        'button.label' => 'Crear Pedido'
                    ]], 'object');
                break;
            default:
                $this->_callBtn = $modal->getShowButton([
                    'options' => [
                        'button.name' => 'showBtn',
                        'button.label' => 'Mostrar'
                    ]], 'object');
                break;
        }

        $this->_content = $modal;

    }
}
