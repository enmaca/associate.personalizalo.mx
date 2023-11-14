<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use App\Support\Workshop\PaymentMethods\SelectPaymentMethods;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Exception;

class PaymentCard extends \Enmaca\LaravelUxmal\Abstract\CardBlock
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

        $form_main_row->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Monto',
                name: 'ammount',
                placeholder: 'Monto',
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