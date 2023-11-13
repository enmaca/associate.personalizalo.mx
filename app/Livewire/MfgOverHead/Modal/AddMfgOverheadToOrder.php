<?php

namespace App\Livewire\MfgOverHead\Modal;

use App\Models\MfgOverhead;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\On;
use Livewire\Component;

class AddMfgOverheadToOrder extends Component
{
    public $content;

    public function mount()
    {
        $this->content = 'Initial::Content';
    }

    #[On('add-mfg-overhead-to-order::mfgoverhead.changed')]
    public function mfgoverhead_changed($mfgoverhead): void
    {
        $__formId = '__' . bin2hex(random_bytes(4));

        $mfgoverhead_data = MfgOverhead::With(['taxes'])->findByHashId($mfgoverhead);

        $tax_factor = 0;
        foreach($mfgoverhead_data->taxes as $tax){
            $tax_factor += $tax->value;
        }
        $one_subtotal = $mfgoverhead_data->value * (1 + $tax_factor);

        $form = \Enmaca\LaravelUxmal\UxmalComponent::Make('form', [
            'options' => [
                'form.id' => $__formId,
                'form.action' => route('orders_post_mfg_overhead')
            ]
        ]);

        $main_row = new \Enmaca\LaravelUxmal\UxmalComponent();

        $main_row->component('ui.row', [
            'options' => [
                'row.slot' => '<h6>'.$mfgoverhead_data->name.'</h6>',
                'row.append-attributes' => [ 'class' => 'm-3']
            ]]);

        $main_row->component('form.input', [
            'options' => [
                'input.type' => 'hidden',
                'hidden.name' => 'mfgOverheadId',
                'hidden.value' => $mfgoverhead_data->hashId
            ]]);

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'number',
                    'input.label' => 'Cantidad',
                    'input.name' => 'mfgOverheadQuantity',
                    'input.value' => 1,
                    'input.min' => 1,
                    'input.required' => true,
                    'input.append-attributes' => [
                        'data-value' => $mfgoverhead_data->value,
                        'data-tax-factor' => $tax_factor,
                    ]
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
                    'input.name' => 'mfgOverheadSubtotal',
                    'input.required' => true,
                    'input.readonly' => true
                ]
            ]]
        ]);

        $form->component('ui.row', ['options' => [
            'row.slot' => $main_row,
            'row.append-attributes' => [
                'data-selected-mfgoverhead-form-id' => $__formId
            ]
        ]]);

        $this->content = View::make($form->view, [
            'data' => $form->toArray()
        ])->render();
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
