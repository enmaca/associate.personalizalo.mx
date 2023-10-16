<?php

namespace App\Livewire\Order\Create;

use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class DynamicTable extends Component
{
    public $orderId;

    public function mount($orderId): void
    {
        $this->orderId = Hashids::decode($orderId)[0];
    }

    public function render()
    {
        return view('livewire.order.create.dynamic-table');
    }
}
