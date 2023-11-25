<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use Enmaca\LaravelUxmal\Block\CardBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Livewire;
use Enmaca\LaravelUxmal\Support\Options\LivewireOptions;
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

        $this->Body()->addElement(Livewire::Options(new LivewireOptions(
            path: 'order-payment-data.form',
            appendData: [
                'values' => $this->GetValues() ?? []
            ]
        )));

        $this->Footer()->addElementInRow(
            element: Button::Options(new ButtonOptions(
                label: 'Agregar Pago',
                name: 'addPaymentFormButton',
                style: 'dark'
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-12 text-end'
                ]
            ));
    }

}