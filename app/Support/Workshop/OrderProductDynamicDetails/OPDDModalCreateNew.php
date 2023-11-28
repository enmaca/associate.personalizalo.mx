<?php

namespace App\Support\Workshop\OrderProductDynamicDetails;

use Enmaca\LaravelUxmal\Block\ModalBlock;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Components\Ui\Modal;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\ModalOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class OPDDModalCreateNew extends ModalBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $form = UxmalComponent::Make('form', [
            'options' => [
                'form.id' => 'OrderProductDynamicDetailsCreateNewForm',
                'form.action' => route('api_post_order_opd', $this->GetValue('order_id')),
                'form.method' => 'POST',
                'autocomplete' => 'off'
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
            element: Input::Options(
                new InputTextOptions(
                    label: 'Descripción',
                    name: 'orderProductDynamicDetailsDescription',
                    placeholder: 'Ingresa la descripción del producto dinámico ...',
                    required: true
                )
            ),
            row_options: new RowOptions(
                appendAttributes: ['class' => 'mt-4 mb-3']
            ));


        $modal = Modal::Options(
            new ModalOptions(
                name: 'modalOrderProductDynamicDetailsCreateNew',
                size: 'xl',
                title: 'Crear Producto Dinámico',
                body: $form,
                saveBtnLabel: 'Crear Producto'
            )
        );

        $this->_callBtn = match ($this->GetContext()) {
            default => $modal->getShowButton(btnAttributes: new ButtonOptions(
                label: 'Crear Nuevo Producto',
                name: 'showBtn'
            ), return_type: 'object')
        };


        $this->SetContent($modal);
    }
}
