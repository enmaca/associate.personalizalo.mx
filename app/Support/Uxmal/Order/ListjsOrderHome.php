<?php

namespace App\Support\Uxmal\Order;

class ListjsOrderHome extends \Enmaca\LaravelUxmal\Abstract\ListJs
{
    public function build()
    {
        $this->_content->setColumns([
            'id' => [
                'tbhContent' => 'checkbox-all',
                'type' => 'primaryKey',
                'handler' => \App\Support\Order\OrderIdCheckbox::class
            ],
            'code' => [
                'tbhContent' => 'Código de pedido'
            ],
            'customer.name' => [
                'tbhContent' => 'Cliente',
            ],
            'status' => [
                'tbhContent' => 'Estatus',
                'handler' => \App\Support\Order\OrderStatus::class
            ],
            'delivery_date' => [
                'tbhContent' => 'Fecha de entrega',
                'handler' => \App\Support\Order\OrderDeliverDate::class
            ],
            'shipment_status' => [
                'tbhContent' => 'Estatus de envio',
                'handler' => \App\Support\Order\OrderShipmentStatus::class
            ],
            'payment_status' => [
                'tbhContent' => 'Estatus de pago',
                'handler' => \App\Support\Order\OrderPaymentStatus::class
            ],
            'payment_ammount' => [
                'tbhContent' => 'Pago',
                'handler' => \App\Support\Order\OrderPaymentAmmount::class
            ]
        ]);


        $this->_content->Model(\App\Models\Order::class)
            ->with([
                'customer' => function ($query) {
                    $query->select([
                        'id',
                        'name'
                    ]);
                }])
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

        $buttons_row =new \Enmaca\LaravelUxmal\Uxmal();

        switch($this->attributes['context']){
            case 'orderhome':
                $buttons_row->component('form.button', [
                    'options' => [
                        'type' => 'normal',
                        'style' => 'primary',
                        'onclick' => 'createOrder()'
                    ],
                    'type' => 'button',
                    'slot' => 'Crear Pedido'
                ]);
                break;
            default:
                break;
        }

        $this->_content->setTopButtons($buttons_row->toArray());
        $this->_content->setPagination(15);

        $this->_content->setSearch(true, ['placeholder' => 'Buscar en pedidos...']);
    }
}