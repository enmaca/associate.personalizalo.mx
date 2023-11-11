<?php

namespace App\Support\Workshop\Order;

class ListjsOrderHome extends \Enmaca\LaravelUxmal\Abstract\TableBlock
{
    public function build(): void
    {
         $table = $this->init(['options' => [
            'table.name' => 'ordersList',
            'table.columns' => [
                'id' => [
                    'tbhContent' => 'checkbox-all',
                    'type' => 'primaryKey',
                    'handler' => \App\Support\Workshop\Order\TbHandler\OrderIdCheckbox::class
                ],
                'code' => [
                    'tbhContent' => 'Código de pedido'
                ],
                'customer.name' => [
                    'tbhContent' => 'Cliente',
                ],
                'status' => [
                    'tbhContent' => 'Estatus',
                    'handler' => \App\Support\Workshop\Order\TbHandler\OrderStatus::class
                ],
                'delivery_date' => [
                    'tbhContent' => 'Fecha de entrega',
                    'handler' => \App\Support\Workshop\Order\TbHandler\OrderDeliverDate::class
                ],
                'shipment_status' => [
                    'tbhContent' => 'Estatus de envio',
                    'handler' => \App\Support\Workshop\Order\TbHandler\OrderShipmentStatus::class
                ],
                'payment_status' => [
                    'tbhContent' => 'Estatus de pago',
                    'handler' => \App\Support\Workshop\Order\TbHandler\OrderPaymentStatus::class
                ],
                'payment_ammount' => [
                    'tbhContent' => 'Pago',
                    'handler' => \App\Support\Workshop\Order\TbHandler\OrderPaymentAmmount::class
                ]
            ],
            'table.data.model' => \App\Models\Order::class
        ]]);

        $table->DataQuery()
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

        $buttons_row = new \Enmaca\LaravelUxmal\UxmalComponent();

        switch ($this->attributes['context']) {
            case 'orderhome':
                $button = $this->_content->component('form.button', [
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

        // $this->_content->setTopButtons($buttons_row->toArray());
        // $this->_content->setPagination(15);

        // $this->_content->setSearch(true, ['placeholder' => 'Buscar en pedidos...']);
    }
}