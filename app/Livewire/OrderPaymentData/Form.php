<?php

namespace App\Livewire\OrderPaymentData;

use App\Models\Order;
use App\Support\Workshop\PaymentMethods\SelectPaymentMethods;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Components\Form as FormComponent;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputCheckboxOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputHiddenOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Enmaca\LaravelUxmal\Support\Options\FormOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{

    public $increment = 0;
    public $values = [];

    private static function Options(FormOptions $param)
    {
    }

    public function mount(mixed $values = []): void
    {
        $this->values = $values;
    }

    #[On('order-payment-data.form::reload')]
    public function reload(): void
    {
        $this->increment++;
    }

    /**
     * @throws Exception
     */
    public function render(): string
    {
        $order_id = Order::keyFromHashId($this->values['order_id']);

        $order_data = Order::findOrFail($order_id)->toArray();

        $uxmal = FormComponent::Options(new FormOptions(
            id: 'addPaymentForm',
            action: '/orders/put_payment',
            method: 'POST'
        ));

        $form_row = $uxmal->addRow(row_options: new RowOptions());

        $form_row->addElementInRow(
            element: SelectPaymentMethods::Object([
                'values' => $this->values
            ]),
            row_options: new RowOptions(
                replaceAttributes: [
                    'wire:ignore' => true,
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $AdvancePaymentCheckbox = Input::Options(new InputCheckboxOptions(
            name: 'advance_payment_50',
            label: 'Anticipo (50%)',
            type: 'switch',
            direction: 'right',
            checked: false,
            disabled: !($order_data['payment_status'] == 'pending'),
        ))->toHtml();



        $form_row->addElement(
            element: Input::Options(new InputHiddenOptions(
                name: 'orderPaymentAmount',
                value: $order_data['payment_amount'] ?? 0
            )));

        $form_row->addElement(
            element: Input::Options(new InputHiddenOptions(
                name: 'orderPrice',
                value: $order_data['price']
            )));

        $form_row->addElement(
            element: Input::Options(new InputHiddenOptions(
                name: 'orderPaymentStatus',
                value: $order_data['payment_status']
            )));

        $form_row->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: '<div class="d-flex" style="align-content: center"><div class="col-6">Monto </div><div class="col-6">' . $AdvancePaymentCheckbox . '</div></div>',
                name: 'amount',
                placeholder: 'Monto',
                value: round(($order_data['price'] - $order_data['payment_amount']), 2),
                required: true,
                labelAppendAttributes: ['style' => ['width: 100%']],
                readonly: true
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        return view($uxmal->view, ['data' => $uxmal->toArray()]);
    }
}
