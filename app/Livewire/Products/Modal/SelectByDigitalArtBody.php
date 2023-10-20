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

        $product_data = Product::With(['digital_category.arts'])->findByHashId($product); //

       dd($product_data->digital_category->arts);

        $this->content = $debug;


        $this->dispatch('select-by-digital-art-body::showmodal');
    }


    public function render()
    {



        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        $uxmal->component('ui.row', [
            'options' => [
                'row.append-attributes' => [
                    'wire:model' => 'content'
                ],
                'row.slot' => $this->content
            ],
        ]);



        return view('uxmal::livewire', ['data' => $uxmal->toArray()]);
    }

}
