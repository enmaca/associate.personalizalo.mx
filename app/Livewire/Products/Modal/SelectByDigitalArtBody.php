<?php

namespace App\Livewire\Products\Modal;

use App\Models\Product;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Livewire\Attributes\On;

class SelectByDigitalArtBody extends Component
{


    public function mount()
    {

    }

    #[NoReturn] #[On('update')]
    public function updating($params): void
    {
        dd($params);

    }


    public function render()
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        $uxmal->component('ui.row', [
            'attributes' => ['class' => ['row' => true]],
            'slot' => bin2hex(random_bytes(8))

        ]);
        return view('uxmal::livewire', ['data' => $uxmal->toArray()]);
    }

}
