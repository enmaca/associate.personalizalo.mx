<?php

namespace App\Livewire\Order\Create;

use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class ProductsTable extends Component
{
    public $orderId;

    public function mount($orderId): void
    {
        $this->orderId = Hashids::decode($orderId)[0];
    }


    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.order.create.products-table');
    }
}
