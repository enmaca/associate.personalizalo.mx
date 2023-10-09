<?php

namespace App\Http\Controllers;

use App\Models\Order;

class Test extends Controller
{
    //
    public function modal() {

        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        $row = $uxmal->component('ui.row');

        $row->component('form.button', [
            'class' => 'btn btn-success add-btn',
            'onclick' => '',
            'id' => 'create-btn',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#createOrderModal',
            'label' => 'Crear Pedido'
        ]);


        $form = new \Enmaca\LaravelUxmal\Components\Form([
            'id' => 'NewOrderFrom',
            'class' => [],
            'action' => route('test'),
            'method' => 'POST']);

        $form_row = $form->component('ui.row', [
            'class' => 'col-6'
        ]);

        $form_row->component('livewire', [
            'path' => 'client.search.select',
            'data' => []
        ]);

        $form_row->component('form.input', [
            'type' => 'text',
            'label' => 'Celular',
            'input-attributes' => [
                'name' => 'customerMobile',
                'placeholder' => 'Ingresa Número de Celular',
                'required' => true
            ]
        ]);

        $form_row->component('form.input', [
            'type' => 'text',
            'label' => 'Nombre',
            'input-attributes' => [
                'name' => 'customerName',
                'placeholder' => 'Ingresa el Nombre',
                'required' => true
            ]
        ]);

        $form_row->component('form.input', [
            'type' => 'text',
            'label' => 'Apellido',
            'input-attributes' => [
                'name' => 'customerLastName',
                'placeholder' => 'Ingresa el Apellido',
                'required' => true
            ]
        ]);

        $form_row->component('form.input', [
            'type' => 'text',
            'label' => 'Correo Electrónico',
            'input-attributes' => [
                'name' => 'customerEmail',
                'placeholder' => 'Ingresa el Correo Electrónico',
                'required' => true
            ]
        ]);

        $modal = $uxmal->component('ui.modal', [
            'class' => 'modal fade',
            'id' => 'createOrderModal',
            'header' => [
                'label' => 'Crear Pedido'
            ],
            'body' => $form,
            'footer' => [
                'elements' => [
                    [
                        'form.button' => [
                            'type' => 'submit',
                            'class' => 'btn btn-success',
                            'onclick' => '',
                            'id' => 'add-btn',
                            'slot' => 'Crear Pedido'
                        ]
                    ]
                ]
            ]
        ]);

        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()
            ])->extends('uxmal::layout.master');
    }

    public function test() {

        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $row = $uxmal->component('ui.row', [
            'class' => 'row'
        ]);

        $row_col_lg_12 = $row->component('ui.row', [
            'class' => 'col-lg-12'
            ]);

        $listjs_card = $row_col_lg_12->component('ui.card', ['header' => ['title' => 'header-title'],
            'body' => true,
            'footer' => 'footer-content']);


        $listjs = $listjs_card->body->component('ui.listjs');

        $listjs->setColumns([
            'id' => [
                'tbhTitle' => null,
                'type' => 'primaryKey',
                'handler' => \App\Support\Order\OrderId::class,
                'visible' => false
            ],
            'code' => [
                'tbhTitle' => 'Código de pedido'
            ],
            'customer.name' => [
                'tbhTitle' => 'Cliente',
            ],
            'status' => [
                'tbhTitle' => 'Estatus',
                'handler' => \App\Support\Order\OrderStatus::class
            ],
            'delivery_date' => [
                'tbhTitle' => 'Fecha de entrega',
                'handler' => \App\Support\Order\OrderDeliverDate::class
            ],
            'shipment_status' => [
                'tbhTitle' => 'Estatus de envio',
                'handler' => \App\Support\Order\OrderShipmentStatus::class
            ],
            'payment_status' => [
                'tbhTitle' => 'Estatus de pago',
                'handler' => \App\Support\Order\OrderPaymentStatus::class
            ],
            'payment_ammount' => [
                'tbhTitle' => 'Pago',
                'handler' => \App\Support\Order\OrderPaymentAmmount::class
            ]
        ]);


        $listjs->Model(Order::class)
            ->with([
            'customer' => function ($query) {
                $query->select([
                    'id',
                    'name'
                ]);}])
            ->select([
                'id',
                'customer_id',
                'code',
                'status',
                'delivery_date',
                'shipment_status',
                'payment_status',
                'payment_ammount']);
            // ->whereIn('id', [1,2,3,4,5]);


        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.master');
    }
}