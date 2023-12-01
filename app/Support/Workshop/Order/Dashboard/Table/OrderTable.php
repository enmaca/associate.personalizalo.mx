<?php

namespace App\Support\Workshop\Order\Dashboard\Table;

use Enmaca\LaravelUxmal\Block\TableBlock;

class OrderTable extends TableBlock
{
    public function build(): void
    {
         $table = $this->init(['options' => [
            'table.name' => 'ordersList',
            'table.columns' => [
                'id' => [
                    'tbhContent' => 'checkbox-all',
                    'type' => 'primaryKey',
                    'handler' => \App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderProducts::class
                ],
                'code' => [
                    'tbhContent' => 'Código de pedido'
                ],
                'customer.name' => [
                    'tbhContent' => 'Cliente',
                ],
                'status' => [
                    'tbhContent' => 'Estatus',
                    'handler' => \App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderStatusHandler::class
                ],
                'delivery_date' => [
                    'tbhContent' => 'Fecha de entrega',
                    'handler' => \App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderDeliverDateHandler::class
                ],
                'shipment_status' => [
                    'tbhContent' => 'Estatus de envio',
                    'handler' => \App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderShipmentStatusHandler::class
                ],
                'payment_status' => [
                    'tbhContent' => 'Estatus de pago',
                    'handler' => \App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPaymentStatusHandler::class
                ],
                'payment_ammount' => [
                    'tbhContent' => 'Pago',
                    'handler' => \App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPriceHandler::class
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