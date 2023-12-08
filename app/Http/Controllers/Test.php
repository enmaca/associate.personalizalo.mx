<?php

namespace App\Http\Controllers;


use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderDeliverDateHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPaymentStatusHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPriceHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderShipmentStatusHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderStatusHandler;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderProductsHandler;
use Enmaca\LaravelUxmal\Support\Enums\BootstrapStylesEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonSizeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonTypeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Ui\Table\TableTypesEnum;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\UI;
use Exception;

class Test extends Controller
{
    //

    public function prueba()
    {
        $form_element = Form::create('test')
            ->action('/pedidos')
            ->method('POST')
            ->content([
                UI::Card('testCard')
                    ->header(
                        UI::Row([
                            UI::Column()
                                ->content('<h1>Crear pedido</h1>')
                                ->align('left'),
                            UI::Column()
                                ->content(
                                    UI::Button('createOrder')
                                        ->label('Crear Pedido')
                                        ->color(ButtonColor::Primary)
                                        ->type(ButtonType::Submit)
                                )
                                ->align('left'),
                        ])
                    )
                    ->body(
                        UI::Table('order')
                            ->data($orders) // Array o Collection
                            ->columns([
                                UI::TableColumn('status')
                                    ->headerLabel('Estatus')
                                    ->render(OrderStatusHandler::class),
                                UI::TableColumn('code')
                                    ->render(OrderStatusHandler::class),
                                UI::TableColumn('customer.name')
                                    ->render(OrderStatusHandler::class),
                                UI::TableColumn('total')
                                    ->render(OrderStatusHandler::class),
                                UI::TableColumn('actions')
                                    ->render(function ($row) {
                                        return UI::Div()
                                            ->hiddenOnAll()
                                            ->hiddenOnXs()
                                            ->hiddenOnSm()
                                            ->hiddenOnMd()
                                            ->hiddenOnLg()
                                            ->hiddenOnXl()
                                            ->hiddenOnxl()
                                            ->hiddenOn2xl()
                                            ->visibleOnAll()
                                            ->visibleOnXs()
                                            ->visibleOnSm()
                                            ->visibleOnMd()
                                            ->visibleOnLg()
                                            ->visibleOnXl()
                                            ->visibleOn2xl()
                                            ->style([
                                                'width' => '100px',
                                                'border' => '1px solid red',
                                            ])
                                            ->display('flex')
                                            ->justify('between')
                                            ->class([
                                                'border-2',
                                                'border-red-500',
                                            ])
                                            ->content([
                                                UI::Button('editOrder')
                                                    ->icon('edit-2-line')
                                                    ->label('Editar')
                                                    ->color(ButtonColor::Info)
                                                    ->type(ButtonType::Submit),
                                                UI::Button('editOrder')
                                                    ->icon('edit-2-line')
                                                    ->label('Editar')
                                                    ->color(ButtonColor::Info)
                                                    ->type(ButtonType::Submit),
                                                UI::Button('changeStatusOrder')
                                                    ->label('Cambiar estatus')
                                                    ->color(ButtonColor::Secondary)
                                                    ->type(ButtonType::Submit)
                                            ]);
                                    }),
                            ])
                    )
            ]);
    }

    /**
     * @throws Exception
     */
    public function test()
    {

        UI::Table('test')
            ->type(TableTypesEnum::Listjs)
            ->listJsPagination(10)
            ->listJsEnableSearch(true)
            ->columns(
                [
                    'hashId' => [
                        'tbhContent' => 'checkbox-all',
                        'type' => 'primaryKey',
                        'handler' => OrderProductsHandler::class
                    ],
                    'code' => [
                        'tbhContent' => 'Código de pedido'
                    ],
                    'customer.name' => [
                        'tbhContent' => 'Cliente',
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
                    'payment_status' => [
                        'tbhContent' => 'Estatus de pago',
                        'handler' => OrderPaymentStatusHandler::class
                    ],
                    'payment_ammount' => [
                        'tbhContent' => 'Pago',
                        'handler' => OrderPriceHandler::class
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
                ]
            )->dataModel(\App\Models\Order::class);

        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }


    public function _test()
    {
        $uxmal = new UxmalComponent();

        $uxmal->addElement(element: Table::Options(TableOptions::Make()
            ->name('test')
            ->type(TableTypesEnum::Listjs)
            ->listJsPagination(10)
            ->listJsEnableSearch(true)
            ->columns(
                [
                    'hashId' => [
                        'tbhContent' => 'checkbox-all',
                        'type' => 'primaryKey',
                        'handler' => OrderProducts::class
                    ],
                    'code' => [
                        'tbhContent' => 'Código de pedido'
                    ],
                    'customer.name' => [
                        'tbhContent' => 'Cliente',
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
                    'payment_status' => [
                        'tbhContent' => 'Estatus de pago',
                        'handler' => OrderPaymentStatusHandler::class
                    ],
                    'payment_ammount' => [
                        'tbhContent' => 'Pago',
                        'handler' => OrderPriceHandler::class
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
                ]
            )->dataModel(\App\Models\Order::class)));

        $uxmal->addScript(Vite::asset('resources/js/test/test.js', 'workshop'));
        $uxmal->addStyle(asset('workshop/css/uxmal.css'));
        $uxmal->addStyle(asset('workshop/css/icons/remixicon.css'));


        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }
}