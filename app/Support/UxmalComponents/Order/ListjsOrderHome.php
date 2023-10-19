<?php

namespace App\Support\UxmalComponents\Order;

class ListjsOrderHome extends \Enmaca\LaravelUxmal\Abstract\ListJs
{
    public function build(): void
    {
        $this->_content->setColumns([
            'id' => [
                'tbhContent' => 'checkbox-all',
                'type' => 'primaryKey',
                'handler' => \App\Support\UxmalComponents\Order\TbHandler\OrderIdCheckbox::class
            ],
            'code' => [
                'tbhContent' => 'Código de pedido'
            ],
            'customer.name' => [
                'tbhContent' => 'Cliente',
            ],
            'status' => [
                'tbhContent' => 'Estatus',
                'handler' => \App\Support\UxmalComponents\Order\TbHandler\OrderStatus::class
            ],
            'delivery_date' => [
                'tbhContent' => 'Fecha de entrega',
                'handler' => \App\Support\UxmalComponents\Order\TbHandler\OrderDeliverDate::class
            ],
            'shipment_status' => [
                'tbhContent' => 'Estatus de envio',
                'handler' => \App\Support\UxmalComponents\Order\TbHandler\OrderShipmentStatus::class
            ],
            'payment_status' => [
                'tbhContent' => 'Estatus de pago',
                'handler' => \App\Support\UxmalComponents\Order\TbHandler\OrderPaymentStatus::class
            ],
            'payment_ammount' => [
                'tbhContent' => 'Pago',
                'handler' => \App\Support\UxmalComponents\Order\TbHandler\OrderPaymentAmmount::class
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

        $buttons_row = new \Enmaca\LaravelUxmal\Uxmal();

        switch ($this->attributes['context']) {
            case 'orderhome':
                $buttons_row->component('form.button', [
                    'options' => [
                        'button.name' => 'orderHome',
                        'button.type' => 'normal',
                        'button.style' => 'primary',
                        'button.onclick' => 'createOrder()',
                        'button.label' => 'Crear Pedido'
                    ]
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