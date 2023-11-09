<?php
namespace App\Support\UxmalComponents\Customer;

use Enmaca\LaravelUxmal\Abstract\ModalBlock;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Components\Ui\Modal;
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
            row_options: ['row.append-attributes' => ['class' => 'mb-3']]
        );

        $main_row->addElementInRow(element: Input::Options([
            'input.type' => 'text',
            'input.label' => 'Celular',
            'input.name' => 'customerMobile',
            'input.placeholder' => '(+52) XXXXXXXXXX',
            'input.required' => true,
            'input.mask.cleave.type' => 'phone',
            'input.mask.cleave.phone.region-code' => 'MX',
            'input.mask.cleave.prefix' => '+52 '
        ]), row_options: ['row.append-attributes' => ['class' => 'mb-3']]);

        $main_row->addElementInRow(element: Input::Options([
            'input.type' => 'text',
            'input.label' => 'Nombre',
            'input.name' => 'customerName',
            'input.placeholder' => 'Ingresa el nombre del cliente',
            'input.required' => true,
        ]), row_options: ['row.append-attributes' => ['class' => 'mb-3']]);


        $main_row->addElementInRow(element: Input::Options([
            'input.type' => 'text',
            'input.label' => 'Apellido',
            'input.name' => 'customerLastName',
            'input.placeholder' => 'Ingresa el apellido del cliente',
            'input.required' => true,
        ]), row_options: ['row.append-attributes' => ['class' => 'mb-3']]);

        $main_row->addElementInRow(element: Input::Options([
            'input.type' => 'text',
            'input.label' => 'Correo Electrónico',
            'input.name' => 'customerEmail',
            'input.placeholder' => 'Ingresa el correo electrónico del cliente',
            'input.required' => true
        ]), row_options: ['row.append-attributes' => ['class' => 'mb-3']]);


        $modal = Modal::Options([
            'modal.name' => 'customerSearchByMobile',
            'modal.title' => 'Buscar/Crear Cliente',
            'modal.body' => $form,
            'modal.saveBtn.label' => 'Crear Pedido',
            'modal.saveBtn.onclick' => 'submitNewOrderFrom()'
        ]);

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
