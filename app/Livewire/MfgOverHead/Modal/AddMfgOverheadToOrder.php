<?php

namespace App\Livewire\MfgOverHead\Modal;

use App\Models\MfgOverhead;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Components\Ui\Row;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputHiddenOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputNumberOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\On;
use Livewire\Component;

class AddMfgOverheadToOrder extends Component
{

    public $increment = 0;
    public $content;

    public function mount(): void
    {
        $this->content = 'Initial::Content';
    }

    /**
     * @throws Exception
     */
    #[On('add-mfg-overhead-to-order::mfgoverhead.changed')]
    public function mfgoverhead_changed($mfgoverhead): void
    {
        $this->increment++;

        $__formId = '__' . bin2hex(random_bytes(4));

        $mfgoverhead_data = MfgOverhead::With(['taxes'])->findByHashId($mfgoverhead);

        $tax_factor = 0;
        foreach ($mfgoverhead_data->taxes as $tax) {
            $tax_factor += $tax->value;
        }
        $one_subtotal = $mfgoverhead_data->value * (1 + $tax_factor);

        $form = UxmalComponent::Make('form', [
            'options' => [
                'form.id' => $__formId,
                'form.action' => route('orders_post_mfg_overhead')
            ]
        ]);

        $main_row = new UxmalComponent();

        $main_row->addRow(row_options: new RowOptions(
            appendAttributes: ['class' => 'm-3'],
            content: '<h6>' . $mfgoverhead_data->name . '</h6>'
        ));

        $main_row->addElement(element: Input::Options(new InputHiddenOptions(
            name: 'mfgOverheadId',
            value: $mfgoverhead_data->hashId
        )));

        $main_row->addElementInRow(element: Input::Options(new InputNumberOptions(
            label: 'Cantidad',
            name: 'mfgOverheadQuantity',
            value: 1,
            required: true,
            appendAttributes: [
                'data-value' => $mfgoverhead_data->value,
                'data-tax-factor' => $tax_factor,
            ],
            min: 1
        )), row_options: new RowOptions(
            appendAttributes: ['class' => 'mb-3']
        ));

        $main_row->addElementInRow(element: Input::Options(new InputTextOptions(
            label: 'Subtotal',
            name: 'mfgOverheadSubtotal',
            value: '$' . number_format($one_subtotal, 2),
            required: true,
            readonly: true
        )), row_options: new RowOptions(
            appendAttributes: ['class' => 'mb-3']
        ));

        $form->addRow(row_options: new RowOptions(
            appendAttributes: [
                'data-selected-mfgoverhead-form-id' => $__formId
            ],
            content: $main_row
        ));

        $this->content = View::make($form->view, [
            'data' => $form->toArray()
        ])->render();
    }

    public function render(): Factory|Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $this->increment++;
        $uxmal = Row::Options(new RowOptions(
            appendAttributes: [
                'wire:model' => 'content'
            ],
            content: $this->content
        ));
        return view($uxmal->view, ['data' => $uxmal->toArray()]);
    }
}
