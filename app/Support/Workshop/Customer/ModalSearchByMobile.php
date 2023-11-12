<?php

namespace App\Support\Workshop\Customer;

use Enmaca\LaravelUxmal\Abstract\ModalBlock;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Components\Ui\Modal;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\ModalOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class ModalSearchByMobile extends ModalBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $form = UxmalComponent::Make('form', [
            'options' => [
                'form.id' => 'NewOrderFrom',
                'form.action' => '/orders',
                'form.method' => 'POST'
            ]
        ]);

        $main_row = $form->addComponent(
            type: 'ui.row',
            attributes: [
                'options' => [
                    'row.append-attributes' => [
                        'class' => 'gy-4']
                ]
            ]);


        $main_row->addElementInRow(
            element: SelectByNameMobileEmail::Object(),
            row_options: new RowOptions(appendAttributes: ['class' => 'mb-3'])
        );

        $main_row->addElementInRow(
            element: Input::Options(
                new InputTextOptions(
                    label: 'Celular',
                    name: 'customerMobile',
                    placeholder: '(+52) XXXXXXXXXX',
                    required: true,
                    maskCleaveType: 'phone',
                    maskCleavePhoneRegionCode: 'MX',
                    maskCleavePrefix: '+52 ',
                )
            ),
            row_options: new RowOptions(
                appendAttributes: ['class' => 'mb-3']
            ));

        $main_row->addElementInRow(
            element: Input::Options(
                new InputTextOptions(
                    label: 'Nombre',
                    name: 'customerName',
                    placeholder: 'Ingresa el nombre del cliente',
                    required: true,
                )
            ),
            row_options: new RowOptions(
                appendAttributes: ['class' => 'mb-3']
            ));


        $main_row->addElementInRow(
            element: Input::Options(
                new InputTextOptions(
                    label: 'Apellido',
                    name: 'customerLastName',
                    placeholder: 'Ingresa el apellido del cliente',
                    required: true
                )
            ),
            row_options: new RowOptions(
                appendAttributes: ['class' => 'mb-3']
            ));

        $main_row->addElementInRow(
            element: Input::Options(
                new InputTextOptions(
                    label: 'Correo Electrónico',
                    name: 'customerEmail',
                    placeholder: 'Ingresa el correo electrónico del cliente',
                    required: true
                )
            ),
            row_options: new RowOptions(
                appendAttributes: ['class' => 'mb-3']
            ));


        $modal = Modal::Options(
            new ModalOptions(
                name: 'customerSearchByMobile',
                title: 'Buscar/Crear Cliente',
                body: $form,
                saveBtnLabel: 'Crear Pedido',
                saveBtnOnClick: 'submitNewOrderFrom()'
            )
        );

        $this->_callBtn = match ($this->GetContext()) {
            'createclient' => $modal->getShowButton([
                'options' => [
                    'button.name' => 'clientAdd',
                    'button.label' => 'Agregar Cliente'
                ]], 'object'),
            'createorder' => $modal->getShowButton([
                'options' => [
                    'button.name' => 'orderCreate',
                    'button.label' => 'Crear Pedido'
                ]], 'object'),
            default => $modal->getShowButton([
                'options' => [
                    'button.name' => 'showBtn',
                    'button.label' => 'Mostrar'
                ]], 'object'),
        };

        $this->SetContent($modal);
    }
}
