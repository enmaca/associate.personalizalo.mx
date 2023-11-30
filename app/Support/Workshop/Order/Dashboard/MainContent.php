<?php

namespace App\Support\Workshop\Order\Dashboard;

use App\Models\Order;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderDeliverDate;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderIdCheckbox;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPaymentAmmount;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPaymentStatus;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderShipmentStatus;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderStatus;
use Enmaca\LaravelUxmal\Block\ContentBlock;
use \Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Ui\Card;
use Enmaca\LaravelUxmal\Components\Ui\Table;
use Enmaca\LaravelUxmal\Support\Enums\BootstrapStylesEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonSizeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonTypeEnum;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\CardOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\TableOptions;

class MainContent extends ContentBlock
{
    /**
     * @throws \Exception
     */
    public function build(): void
    {

        $buttonCreateOrder = Button::Options(
            ButtonOptions::Make()
                ->name('createOrder')
                ->label('Crear Pedido')
                ->style('primary')
                ->type('normal')
        );

        $ordersCard = Card::Options(
            CardOptions::make()
                ->name('ordersCard')
                ->header('Listado de Pedidos')
                ->style('primary')
                ->headerRight($buttonCreateOrder->toHtml())
        );

        $deleteButton = new ButtonOptions(
            name: 'editOrder',
            style: 'info',
            type: 'icon',
            appendAttributes: [
                'data-workshop-order-edit' => true
            ],
            remixIcon: 'edit-2-line'
        );

        $tableOrders = Table::Options(
            TableOptions::Make()
                ->name('ordersTable')
                ->columns(
                    [
                        'hashId' => [
                            'tbhContent' => 'checkbox-all',
                            'type' => 'primaryKey',
                            'handler' => OrderIdCheckbox::class
                        ],
                        'code' => [
                            'tbhContent' => 'Código de pedido'
                        ],
                        'customer.name' => [
                            'tbhContent' => 'Cliente',
                        ],
                        'status' => [
                            'tbhContent' => 'Estatus',
                            'handler' => OrderStatus::class
                        ],
                        'delivery_date' => [
                            'tbhContent' => 'Fecha de entrega',
                            'handler' => OrderDeliverDate::class
                        ],
                        'shipment_status' => [
                            'tbhContent' => 'Estatus de envio',
                            'handler' => OrderShipmentStatus::class
                        ],
                        'payment_status' => [
                            'tbhContent' => 'Estatus de pago',
                            'handler' => OrderPaymentStatus::class
                        ],
                        'payment_ammount' => [
                            'tbhContent' => 'Pago',
                            'handler' => OrderPaymentAmmount::class
                        ],
                        'actions' => [
                            'tbhContent' => null,
                            'buttons' => [
                                ButtonOptions::Make()
                                    ->name('editOrder@@uniqueId@@')
                                    ->style(BootstrapStylesEnum::Info)
                                    ->type(ButtonTypeEnum::Icon)
                                    ->size(ButtonSizeEnum::Small)
                                    ->appendAttributes([
                                        'data-workshop-order-edit' => true
                                    ])
                                    ->remixIcon('edit-2-line'),
                                ButtonOptions::Make()
                                    ->name('changeStatusOrder@@uniqueId@@')
                                    ->style(BootstrapStylesEnum::Secondary)
                                    ->type(ButtonTypeEnum::Icon)
                                    ->size(ButtonSizeEnum::Small)
                                    ->appendAttributes([
                                        'data-workshop-order-change' => true
                                    ])
                                    ->remixIcon('article-line')
                            ]
                        ]
                    ])
                ->dataModel(Order::class));


        $ordersCard->Body()->addElement(element: $tableOrders);

        $tableOrders->DataQuery()
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
                'payment_amount']);





        $this->ContentRow()->addElement(element: $ordersCard);

    }
}