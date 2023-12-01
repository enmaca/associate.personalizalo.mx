<?php

namespace App\Support\Workshop\Order\Dashboard;

use App\Models\Order;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderDeliverDateHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderIdCheckboxHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPaymentAmountHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPriceHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPaymentStatusHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderProductsDynamicHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderCustomerHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderProductsHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderShipmentStatusHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderStatusHandler;
use Enmaca\LaravelUxmal\Block\ContentBlock;
use \Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Ui\Card;
use Enmaca\LaravelUxmal\Components\Ui\Table;
use Enmaca\LaravelUxmal\Support\Enums\BootstrapStylesEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonSizeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonTypeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Ui\Table\TableTypesEnum;
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
                ->type(TableTypesEnum::Listjs)
                ->listJsPagination(10)
                ->listJsEnableSearch(true)
                ->columns(
                    [
                        'hashId' => [
                            'tbhContent' => null,
                            'type' => 'primaryKey',
                            'handler' => OrderIdCheckboxHandler::class
                        ],
                        'code' => [
                            'tbhContent' => 'Código'
                        ],
                        'customer' => [
                            'tbhContent' => 'Cliente',
                            'handler' => OrderCustomerHandler::class
                        ],
                        'products' => [
                            'tbhContent' => 'Productos',
                            'handler' => OrderProductsHandler::class
                        ],
                        'dynamic_products' => [
                            'tbhContent' => 'Prod. Dinámicos',
                            'handler' => OrderProductsDynamicHandler::class
                        ],
                        'status' => [
                            'tbhContent' => 'Estatus',
                            'handler' => OrderStatusHandler::class
                        ],
                        'delivery_date' => [
                            'tbhContent' => 'Fecha de entrega',
                            'handler' => OrderDeliverDateHandler::class
                        ],
                        'shipment_status' => [
                            'tbhContent' => 'Estatus de envio',
                            'handler' => OrderShipmentStatusHandler::class
                        ],
                        'price' => [
                            'tbhContent' => 'Precio',
                            'handler' => OrderPriceHandler::class
                        ],
                        'payment_status' => [
                            'tbhContent' => 'Estatus de pago',
                            'handler' => OrderPaymentStatusHandler::class
                        ],
                        'payment_amount' => [
                            'tbhContent' => 'Pago',
                            'handler' => OrderPaymentAmountHandler::class
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
                        'name',
                        'last_name',
                        'email',
                        'mobile',
                    ]);
                },
                'products' => function ($query) {
                    $query->select([
                        'id',
                        'order_id'
                    ]);
                },
                'dynamic_products' => function ($query) {
                    $query->select([
                        'id',
                        'order_id',
                        'description',
                        'mfg_status'
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
                'payment_amount',
                'price'
            ]);


        $this->ContentRow()->addElement(element: $ordersCard);

    }
}