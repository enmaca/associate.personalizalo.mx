<?php

namespace App\Http\Controllers;

use App\Models\DigitalArt;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class Test extends Controller
{
    //
    public function modal()
    {
//'components.ui.swiper'

        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $row = $uxmal->component('ui.swiper');

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

    public function listjs()
    {

        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $main_row = $uxmal->component('ui.row', [
            'attributes' => [
                'class' => [
                    'row' => true
                ]
            ]
        ]);

        $listjs = \Enmaca\LaravelUxmal\Uxmal::component('ui.listjs');

        $listjs->setColumns([
            'id' => [
                'tbhContent' => 'checkbox',
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


        $listjs->Model(Order::class)
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

        $listjs->setPagination(10);

        $listjs->setSearch(true, ['placeholder' => 'Buscar en pedidos...']);

        $card = $main_row->component('ui.card', [
            'options' => [
                'header' => 'HeaderTitle',
                'body' => $listjs,
                'footer' => 'FooterTitle'
            ]
        ]);

        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.master');
    }

    public function button()
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $row = $uxmal->component('ui.row', [
            'class' => 'row'
        ]);

        $row_col_lg_12 = $row->component('ui.row', [
            'class' => 'col-lg-12'
        ]);


        $row_col_lg_12->component('form.button', [
            'attributes' => [
                'onclick' => 'console.log("NewCheck")'
            ],
            'type' => 'button',
            'slot' => 'buttonCodeEnmaca'
        ]);
        $row_col_lg_12->component('form.button', [
            'options' => [
                'type' => 'outline'
            ],
            'attributes' => [
                'onclick' => 'console.log("NewCheck")'
            ],
            'type' => 'button',
            'slot' => 'buttonCodeEnmaca'
        ]);
        $row_col_lg_12->component('form.button', [
            'options' => [
                'type' => 'soft'
            ],
            'attributes' => [
                'onclick' => 'console.log("NewCheck")'
            ],
            'type' => 'button',
            'slot' => 'buttonCodeEnmaca'
        ]);
        $row_col_lg_12->component('form.button', [
            'options' => [
                'type' => 'darken'
            ],
            'attributes' => [
                'onclick' => 'console.log("NewCheck")'
            ],
            'type' => 'button',
            'slot' => 'buttonCodeEnmaca'
        ]);
        $row_col_lg_12->component('form.button', [
            'options' => [
                'type' => 'ghost'
            ],
            'attributes' => [
                'onclick' => 'console.log("NewCheck")'
            ],
            'type' => 'button',
            'slot' => 'buttonCodeEnmaca'
        ]);
        $formStruct = null;

        $form = $row_col_lg_12->component('form', $formStruct->toArray());


        //dd($uxmal->toArray());

        return view('workshop.test', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.master');
    }

    public function test__()
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $main_row = $uxmal->component('ui.row', [
            'attributes' => [
                'class' => [
                    'row' => true
                ]
            ]
        ]);

        $listjs = \Enmaca\LaravelUxmal\Uxmal::component('ui.listjs', [

        ]);

        $listjs->setColumns([
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


        $listjs->Model(Order::class)
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

        $listjs->setPagination(10);

        $listjs->setSearch(true, ['placeholder' => 'Buscar en pedidos...']);

        $card = $main_row->component('ui.card', [
            'options' => [
                'header' => 'HeaderTitle',
                'body' => $listjs,
                'footer' => 'FooterTitle'
            ]
        ]);

        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.master');
    }


    public function __test()
    {

        $form = new \Enmaca\LaravelUxmal\Uxmal();

        $form->component('form.select.tomselect', [
            'options' => [
                'label' => 'Buscar Cliente',
                'select.model' => \App\Models\Customer::class,
                'select.placeholder' => 'Ingresa nombre, telefono o email...',
                'tomselect.populate-url' => '/test/tomselect_populate',
                'tomselect.load-url' => '/test/tomselect_load'
            ]
        ]);

        return view('uxmal::simple-default', [
            'uxmal_data' => $form->toArray()
        ])->extends('uxmal::layout.simple');
    }

    public function tomselect_load(Request $request)
    {

        $search = json_decode($request->getContent(), true);

        $customers = Customer::query()
            ->where('mobile', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->get();


        $items = [];
        foreach ($customers->toArray() as $customer) {
            $items[] = [
                'value' => $customer['id'],
                'label' => "{$customer['name']} {$customer['last_name']} [{$customer['mobile']}] ({$customer['email']})"
            ];
        }

        return response()->json([
            'incomplete_results' => false,
            'items' => $items,
            'total_count' => count($items)
        ]);
    }

    public function test()
    {
        //'components.'
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $DAdata = DigitalArt::where('da_category_id', 2)->select('id', 'thumbnail_path')->get();
        $items = [];
        foreach ($DAdata->toArray() as $digital_art)
            $items[] = [
                'id' => $digital_art['id'],
                'slot' => '<img src="' . $digital_art['thumbnail_path'] . '" alt="Image 2">'
            ];


        $uxmal->component('ui.swiper', [
            'options' => [
                'swiper.container.style' => [
                    'width' => '100%',
                    'height' => '300px'
                ],
                'swiper.name' => 'digitalArtSwiper',
                'swiper.items' => $items,
                'swiper.config.slides-per-view' => 3,
                'swiper.config.grid.rows' => 1,
                'swiper.config.space-between' => 30,
                'swiper.config.pagination.el' => '.swiper-pagination',
                'swiper.config.pagination.clickable' => true
            ]
        ]);

        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }
}