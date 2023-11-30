<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderDeliverDate;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderIdCheckbox;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPaymentAmmount;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderPaymentStatus;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderShipmentStatus;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderStatus;
use App\Support\Workshop\Order\EditScreen\MainContent\ClientCard;
use Enmaca\LaravelUxmal\Components\Ui\Row;
use Enmaca\LaravelUxmal\Components\Ui\Table;
use Enmaca\LaravelUxmal\Support\Enums\BootstrapStylesEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonSizeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonTypeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonWidthSizeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Ui\Table\TableTypesEnum;
use Enmaca\LaravelUxmal\Support\Helpers\BuildRoutesHelper;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\CardOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\TableOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;

class Test extends Controller
{
    //

    /**
     * @throws Exception
     */
    public function test()
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