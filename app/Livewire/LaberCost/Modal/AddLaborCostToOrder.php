<?php

namespace App\Livewire\LaberCost\Modal;

use App\Models\LaborCost;
use App\Models\MfgOverhead;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\On;
use Livewire\Component;

class AddLaborCostToOrder extends Component
{
    public $content;

    public function mount()
    {
        $this->content = 'Initial::Content';
    }

    #[On('add-labor-cost-to-order::laborcost.changed')]
    public function laborcost_changed($laborcost): void
    {
        $__formId = '__' . bin2hex(random_bytes(4));

        $laborcost_data = LaborCost::With(['taxes'])->findByHashId($laborcost);

        $tax_factor = 0;
        foreach($laborcost_data->taxes as $tax){
            $tax_factor += $tax->value;
        }

        $cost_by_minute = $laborcost_data->cost_by_hour / 60;

        $one_subtotal = ($cost_by_minute * $laborcost_data->min_fraction_cost_in_minutes) * (1 + $tax_factor);

        $form = \Enmaca\LaravelUxmal\Uxmal::component('form', [
            'options' => [
                'form.id' => $__formId,
                'form.action' => route('orders_post_labor_cost')
            ]
        ]);

        $main_row = new \Enmaca\LaravelUxmal\Uxmal();

        $main_row->component('ui.row', [
            'options' => [
                'row.slot' => '<h6>'.$laborcost_data->name.'</h6>',
                'row.append-attributes' => [ 'class' => 'm-3']
            ]]);

        $main_row->component('form.input', [
                'options' => [
                    'input.type' => 'hidden',
                    'hidden.name' => 'laborCostId',
                    'hidden.value' => $laborcost_data->hashId
                ]]);

        $main_row->componentsInDiv(['options' => [ 'row.append-attributes' => [ 'class' => 'mb-3'] ]], [[
            'path' => 'form.input',
            'attributes' => [
                'options' => [
                    'input.type' => 'number',
                    'input.label' => 'Cantidad (Minimo ['.$laborcost_data->min_fraction_cost_in_minutes.'] Minutos)',
                    'input.name' => 'laborCostQuantity',
                    'input.value' => $laborcost_data->min_fraction_cost_in_minutes,
                    'input.min' => $laborcost_data->min_fraction_cost_in_minutes,
                    'input.required' => true,
                    'input.append-attributes' => [
                        'data-value' => $cost_by_minute,
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
                    'input.name' => 'laborCostSubtotal',
                    'input.required' => true,
                    'input.readonly' => true,
                    'input.append-attributes' => [
                        'data-value' => $cost_by_minute,
                        'data-tax-factor' => $tax_factor,
                    ]
                ]
            ]]
        ]);

        $form->component('ui.row', ['options' => [
            'row.slot' => $main_row,
            'row.append-attributes' => [
                'data-selected-laborcost-form-id' => $__formId
            ]
        ]]);

        $this->content = View::make($form->view, [
            'data' => $form->toArray()
        ])->render();

        $this->dispatch('add-to-order::show-laborcost-modal');
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
