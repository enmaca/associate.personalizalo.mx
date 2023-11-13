<?php

namespace App\Livewire\Material\Modal;

use App\Models\Material;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Components\Ui\Row;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputHiddenOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputNumberOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\On;
use Livewire\Component;

class AddMaterialToOrder extends Component
{
    public $content;
    public $increment = 0;

    public function mount()
    {
        $this->content = 'Initial::Content';
    }

    /**
     * @throws Exception
     */
    #[On('add-material-to-order::material.changed')]
    public function material_changed($material): void
    {
        $this->increment++;

        $__formId = '__' . bin2hex(random_bytes(4));

        $material_data = Material::With(['unit_of_measure', 'taxes'])->findByHashId($material);

        $tax_factor = 0;
        foreach ($material_data->taxes as $tax) {
            $tax_factor += $tax->value;
        }
        $one_subtotal = $material_data->invt_uom_cost * (1 + $tax_factor);

        $form = UxmalComponent::Make('form', [
            'options' => [
                'form.id' => $__formId,
                'form.action' => route('orders_post_material')
            ]
        ]);

        $main_row = new UxmalComponent();

        $main_row->addRow(row_options: new RowOptions(
            appendAttributes: ['class' => 'm-3'],
            content: '<h6>' . $material_data->name . '</h6>'
        ));

        $main_row->addElement(element: Input::Options(new InputHiddenOptions(
            name: 'materialId',
            value: $material_data->hashId
        )));

        $main_row->addElementInRow(element: Input::Options(new InputNumberOptions(
            label: 'Cantidad ( ' . $material_data->invt_quantity . ' en Existencia)',
            name: 'materialQuantity',
            value: 1,
            required: true,
            appendAttributes: [
                'data-uom-cost' => $material_data->invt_uom_cost,
                'data-tax-factor' => $tax_factor,
            ],
            min: 1,
            max: $material_data->invt_quantity
        )), row_options: new RowOptions(
            appendAttributes: ['class' => 'mb-3']
        ));

        $main_row->addElementInRow(element: Input::Options(new InputNumberOptions(
            label: 'Margen (Porcentaje)',
            name: 'materialProfitMargin',
            value: 35,
            required: true,
            min: 5
        )), row_options: new RowOptions(
            appendAttributes: ['class' => 'mb-3']
        ));

        $main_row->addElementInRow(element: Input::Options(new InputTextOptions(
            label: 'Subtotal',
            name: 'materialSubtotal',
            value: '$' . number_format($one_subtotal, 2),
            required: true,
            readonly: true
        )), row_options: new RowOptions(
            appendAttributes: ['class' => 'mb-3']
        ));

        $form->addRow( row_options: new RowOptions(
            appendAttributes: [
                'data-selected-material-form-id' => $__formId
            ],
            content: $main_row
        ));

        $this->content = View::make($form->view, [
            'data' => $form->toArray()
        ])->render();
    }

    /**
     * @throws Exception
     */
    public function render()
    {
        $this->increment++;
        $uxmal = Row::Options(new RowOptions(
            appendAttributes: [
                'wire:key' => $this->increment
            ],
            content: $this->content
        ));
        return view('uxmal::livewire', ['data' => $uxmal->toArray()]);
    }
}
