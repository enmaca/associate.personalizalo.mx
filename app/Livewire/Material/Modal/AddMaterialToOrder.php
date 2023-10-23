<?php

namespace App\Livewire\Material\Modal;

use Livewire\Attributes\On;
use Livewire\Component;

class AddMaterialToOrder extends Component
{
    public $content;

    public function mount()
    {
        $this->content = 'Initial::Content';
    }

    #[On('add-material-to-order::material.changed')]
    public function material_changed($material): void
    {
        $this->content = 'Event::Content::'.$material;

        $this->dispatch('add-material-to-order::showmodal');
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
