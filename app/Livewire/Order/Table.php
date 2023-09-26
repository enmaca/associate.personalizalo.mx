<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\Order;

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

    public $orders;

    public function render()
    {
        $this->orders = Order::with([
            'details',
            'customer',
            'payments',
            'address'
        ])->where('status', '!=', 'done')
            ->orWhere('status','!=', 'canceled')->get()->toArray();
//dd($this->orders);

        return view('livewire.order.table');
    }
}
