<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\Order;
use Vinkla\Hashids\Facades\Hashids;

class Table extends Component
{
    public $order_status_tr = [
        'new' => 'Nuevo',
        'processing' => 'En Proceso',
        'finished' => 'Terminado',
        'canceled' => 'Cancelado'
    ];

    public $shipment_status_tr = [
        'not_needed' => 'Recoge en Tienda',
        'pending' => 'Pendiente',
        'shipped' => 'Enviado',
        'delivered' => 'Entregado'
    ];

    public $tableStruct;

    public function render()
    {


        $orders = Order::with([
            'details',
            'customer',
            'payments',
            'address',
            'address.district',
            'address.municipality',
            'address.state'
        ])->where('status', '!=', 'done')
            ->orWhere('status', '!=', 'canceled')->get()->toArray();

        $this->tableStruct['data'] = [];
        foreach ($orders as $order) {
            $order_address_book = '';
            if (!empty($order['address'])) {
                $order_address_book .= "Nombre: " . $order['address']['name'] . " " . $order['address']['last_name'] . "\n";
                $order_address_book .= "Teléfono: " . $order['address']['contact_mobile'] . "\n";
                $order_address_book .= "Direccién:\n" . $order['address']['address_1'] . "\n" . $order['address']['address_2'] . "\n" . $order['address']['zip_code'];
            }
            $this->tableStruct['data'][] = [
                'checkbox' => Hashids::encode($order['id']),
                'id' => Hashids::encode($order['id']),
                'order_code' => $order['code'],
                'customer_name' => $order['customer']['name'] . " " . $order['customer']['last_name'],
                'customer_mobile' => $order['customer']['mobile'],
                'order_delivery_date' => $order['delivery_date'],
                'order_address_book' => '',
                'order_status' => '<span class="badge text-success  bg-success-subtle text-uppercase">' . $this->order_status_tr[$order['status']] . '</span>',
                'order_shipment_status' => '<span class="badge text-success  bg-success-subtle text-uppercase">' . $this->shipment_status_tr[$order['shipment_status']] . '</span>',
                'action' => [
                    [
                        'name' => 'edit',
                        'data' => [
                            'type' => 'button',
                            'class' => 'btn btn-soft-success add-btn',
                            'onclick' => "__edit('" . Hashids::encode($order['id']) . "')",
                            'slot' => '<i class="ri-edit-box-line"></i>',
                        ]
                    ],
                    [
                        'name' => 'cancel',
                        'data' => [
                            'type' => 'button',
                            'class' => 'btn btn-soft-danger',
                            'onclick' => "__cancel('" . Hashids::encode($order['id']) . "')",
                            'slot' => '<i class="ri-shield-fill"></i>',
                        ]
                    ]
                ]
            ];
        }
        return view('livewire.order.table');
    }
}
