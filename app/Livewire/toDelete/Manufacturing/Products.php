<?php

namespace App\Livewire\Manufacturing;

use App\Models\OrderProductDetail;
use Livewire\Component;

class Products extends Component
{
    public $products;

    public function render()
    {
        $this->products = OrderProductDetail::with(['order', 'product', 'mfg_device', 'mfg_device.mfg_area'])
            ->whereHas('order', function($query){
                $query->where('status', '!=', 'done')
                    ->orWhere('status','!=', 'canceled');
            })->get()->toArray();
        //dd($this->products);
        return view('livewire.manufacturing.products');
    }
}
