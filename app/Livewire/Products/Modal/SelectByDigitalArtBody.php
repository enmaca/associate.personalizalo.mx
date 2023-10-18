<?php

namespace App\Livewire\Products\Modal;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class SelectByDigitalArtBody extends Component
{
    public $content;

    public function mount()
    {
        $this->content = 'Initial Content';
    }

    #[On('select-by-digital-art-body::product.changed')]
    public function product_changed($product): void
    {
        $this->content = $product;
        $this->dispatch('select-by-digital-art-body::showmodal');
    }


    public function render()
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        $uxmal->component('ui.row', [
            'attributes' => [
                'wire:model' => 'content',
                'class' => [
                    'row' => true
                ]
            ],
            'slot' => $this->content
        ]);
        return view('uxmal::livewire', ['data' => $uxmal->toArray()]);
    }

}
