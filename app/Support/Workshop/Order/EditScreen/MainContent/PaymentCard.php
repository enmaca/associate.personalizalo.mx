<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use App\Support\Workshop\PaymentMethods\SelectPaymentMethods;
use Enmaca\LaravelUxmal\Abstract\CardBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputCheckboxOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Exception;

class PaymentCard extends CardBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $main_row = $this->Body()->addRow();

        $form = $main_row->addComponent('form', [
            'options' => [
                'form.id' => 'addPaymentForm',
                'form.action' => '/orders',
                'form.method' => 'POST'
            ]
        ]);

        $form_main_row = $form->addRow();

        $form_main_row->addElementInRow(
            element: SelectPaymentMethods::Object([
                'values' => $this->GetValues()
            ]),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $AdvancePaymentCheckbox = Input::Options(new InputCheckboxOptions(
            name: 'advance_payment_50',
            label: 'Anticipo (50%)',
            type: 'switch',
            direction: 'right',
            checked: false
        ))->toHtml();

        $form_main_row->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: '<div class="d-flex" style="align-content: center"><div class="col-6">Monto </div><div class="col-6">'.$AdvancePaymentCheckbox.'</div></div>',
                name: 'amount',
                placeholder: 'Monto',
                labelAppendAttributes: [ 'style' => [ 'width: 100%' ] ],
                disabled: true
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->Footer()->addElementInRow(
            element: Button::Options( new ButtonOptions(
                label: 'Agregar Pago',
                name: 'addPaymentFormButton',
                style: 'info'
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-12 text-end'
                ]
            ));
    }

}