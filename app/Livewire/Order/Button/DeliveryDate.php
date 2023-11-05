<?php

namespace App\Livewire\Order\Button;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class DeliveryDate extends Component
{

    public $order_id;

    public function mount($order_id){
        $this->order_id = $order_id;
    }

    #[On('order.button.delivery-date::reload')]
    public function reload(){}

    public function render(): string
    {
        $order_data = Order::findOrFail(Order::keyFromHashId($this->order_id));
        return '<div>'. \Enmaca\LaravelUxmal\Components\Form\Button::Render([
            'button.type' => 'with-label',
            'button.style' => is_null($order_data->delivery_date) ? 'danger' : ((Carbon::parse($order_data->delivery_date)->isToday() || Carbon::parse($order_data->delivery_date)->isTomorrow()) ? 'warning' : 'success'),
            'button.name' => 'orderDeliveryDateButton',
            'button.label' => $order_data->delivery_date ?? 'Agregar Fecha de Entrega',
            'button.remix-icon' => 'calendar-event-line'
        ]).'</div>';
    }
}
