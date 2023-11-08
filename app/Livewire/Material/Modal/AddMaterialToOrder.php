<?php

namespace App\Livewire\Material\Modal;

use App\Models\Material;
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
        dd('ok');
*/

        $tax_factor = 0;
        foreach($material_data->taxes as $tax){
            $tax_factor += $tax->value;
        }
        $one_subtotal = $material_data->invt_uom_cost * (1 + $tax_factor);

        $form = \Enmaca\LaravelUxmal\UxmalComponent::Make('form', [
            'options' => [
                'form.id' => $__formId,
                'form.action' => route('orders_post_material')
            ]
        ]);

        $main_row = new \Enmaca\LaravelUxmal\UxmalComponent();

        $main_row->component('ui.row', [
            'options' => [
                'row.slot' => '<h6>'.$material_data->name.'</h6>',
                'row.append-attributes' => [ 'class' => 'm-3']
            ]]);

        $main_row->component('form.input', [
            'options' => [
                'input.type' => 'hidden',
                'hidden.name' => 'materialId',
                'hidden.value' => $material_data->hashId
            ]]);

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'number',
                    'input.label' => 'Cantidad ( '.$material_data->invt_quantity.' en Existencia)',
                    'input.name' => 'materialQuantity',
                    'input.value' => 1,
                    'input.max' => $material_data->invt_quantity,
                    'input.min' => 1,
                    'input.required' => true,
                    'input.append-attributes' => [
                        'data-uom-cost' => $material_data->invt_uom_cost,
                        'data-tax-factor' => $tax_factor,
                    ]
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
                    'input.required' => true,
                    'input.event-change-handler' => 'updateMaterialSubtotal()'
                ]
            ]]
        ]);

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'text',
                    'input.label' => 'Subtotal',
                    'input.value' => '$'.number_format($one_subtotal,2),
                    'input.name' => 'materialSubtotal',
                    'input.required' => true,
                    'input.readonly' => true
                ]
            ]]
        ]);

        $form->component('ui.row', ['options' => [
            'row.slot' => $main_row,
            'row.append-attributes' => [
                'data-selected-material-form-id' => $__formId
            ]
        ]]);

        $this->content = View::make($form->view, [
            'data' => $form->toArray()
        ])->render();

        $this->dispatch('add-to-order::show-material-modal');
    }

    public function render()
    {
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
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
