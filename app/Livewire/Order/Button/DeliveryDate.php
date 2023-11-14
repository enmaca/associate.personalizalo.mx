<?php

namespace App\Livewire\Order\Button;

use App\Models\Order;
use Carbon\Carbon;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Livewire\Attributes\On;
use Livewire\Component;

class DeliveryDate extends Component
{

    public $order_id;
    public $increment = 0;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    #[On('order.button.delivery-date::reload')]
    public function reload()
    {
        $this->increment++;
    }

    public function render(): string
    {
        $order_data = Order::findOrFail(Order::keyFromHashId($this->order_id));
        return '<div>' . Button::Render(new ButtonOptions(
                label: $order_data->delivery_date ?? 'Agregar Fecha de Entrega',
                name: 'orderDeliveryDateButton',
                style: is_null($order_data->delivery_date) ? 'danger' : ((Carbon::parse($order_data->delivery_date)->isToday() || Carbon::parse($order_data->delivery_date)->isTomorrow()) ? 'warning' : 'success'),
                type: 'with-label',
                remixIcon: 'calendar-event-line'
            )) . '</div>';
    }
}
