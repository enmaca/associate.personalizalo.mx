<?php

namespace App\Livewire\Material\Modal;

use App\Models\Material;
use App\Support\UxmalComponents\Customer\SelectByNameMobileEmail;
use Illuminate\Support\Facades\View;
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
        $__formId = '__' . bin2hex(random_bytes(4));

        $material_data = Material::With([
            'unit_of_measure',
            'taxes'])->findByHashId($material); //

        /*
        dump($material_data->toArray());
        dump($material_data->unit_of_measure->toArray());
        */


        $form = \Enmaca\LaravelUxmal\Uxmal::component('form', [
            'options' => [
                'form.id' => 'addMaterialToOrder',
                'form.action' => '/order/addproduct'
            ]
        ]);

        $main_row = $form->component('ui.row');


        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'number',
                    'input.label' => 'Cantidad',
                    'input.name' => 'materialQuantity',
                    'input.value' => 1,
                    'input.max' => $material_data->invt_quantity,
                    'input.min' => 1,
                    'input.required' => true
                ]
            ]]
        ]);

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'number',
                    'input.label' => 'Margen (Porcentaje)',
                    'input.name' => 'materialProfitMargin',
                    'input.value' => 35,
                    'input.min' => 5,
                    'input.required' => true
                ]
            ]]
        ]);


        $tax_factor = 0;
        foreach($material_data->taxes as $tax){
            $tax_factor += $tax->value;
        }


        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'text',
                    'input.label' => 'Subtotal',
                    'input.name' => 'materialSubtotal',
                    'input.required' => true,
                    'input.readonly' => true,
                    'input.append-attributes' => [
                        'data-workshop-tax-factor' => $tax_factor
                    ]
                ]
            ]]
        ]);

        $this->content = View::make($form->view, [
            'data' => $main_row->toArray()
        ])->render();

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
