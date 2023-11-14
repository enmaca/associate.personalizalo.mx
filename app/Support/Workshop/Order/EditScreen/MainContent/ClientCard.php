<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use Enmaca\LaravelUxmal\Abstract\CardBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Illuminate\Support\Str;
use Exception;

class ClientCard extends CardBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {

        $this->attributes['options']['customer.card.readonly'] ??= true;


        $this->NewBodyRow(new RowOptions(
            replaceAttributes: [
                'class' => 'bg-light border-bottom border-top p-3'
            ],
            content: '<h5>Datos del cliente</h5>'
        ));

        $this->NewBodyRow(new RowOptions(
            replaceAttributes: [
                'class' => 'row mt-3'
            ]
        ));

        $this->BodyRow()->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Celular',
                name: 'customerMobile',
                placeholder: '(+52) XXXXXXXXXX',
                value: $this->GetValue(str::snake('customerMobile')) ?? '',
                required: true,
                readonly: true
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->BodyRow()->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Nombre',
                name: 'customerName',
                placeholder: 'Ingresa el nombre del cliente',
                value: $this->GetValue(str::snake('customerName')) ?? '',
                required: true,
                readonly: true
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->BodyRow()->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Apellido',
                name: 'customerLastName',
                placeholder: 'Ingresa el apellido del cliente',
                value: $this->GetValue(str::snake('customerLastName')) ?? '',
                required: true,
                readonly: true
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->BodyRow()->addElementInRow(
            element: Input::Options(new InputTextOptions(
                label: 'Correo Electrónico',
                name: 'customerEmail',
                placeholder: 'Ingresa el correo electrónico del cliente',
                value: $this->GetValue(str::snake('customerEmail')) ?? '',
                required: true,
                readonly: true
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->Footer()->addElementInRow(
            element: Button::Options(new ButtonOptions(
                label: 'Guardar cambios',
                name: 'addressBookSubmit',
                style: 'primary',
                appendAttributes: ['class' => ['d-none' => true]]
            )),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-12 text-end'
                ]
            ));

        $this->NewBodyRow(new RowOptions(
            replaceAttributes: [
                'class' => 'row'
            ]
        ))->addElement(UxmalComponent::Make('livewire', [
            'options' => [
                'livewire.path' => 'addressbook.form.default-form',
                'livewire.append-data' => [
                    'order_id' => $this->GetValue('order_id')
                ]
            ]
        ]));
    }

}