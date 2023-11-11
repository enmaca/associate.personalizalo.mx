<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use App\Support\Workshop\AddressBook\DefaultForm as AddressBookDefaultForm;
use Carbon\Carbon;
use Enmaca\LaravelUxmal\Abstract\CardBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
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

        $this->BodyRow(true, [
            'row.slot' => '<h5>Datos del cliente</h5>',
            'row.append-attributes' => [
                'class' => 'bg-light border-bottom border-top p-3'
            ]
        ]);

        $this->BodyRow();

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Celular',
            'input.name' => 'customerMobile',
            'input.placeholder' => '(+52) XXXXXXXXXX',
            'input.value' => $this->attributes['values'][str::snake('customerMobile')] ?? '',
            'input.required' => true,
            'input.readonly' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Nombre',
            'input.name' => 'customerName',
            'input.placeholder' => 'Ingresa el nombre del cliente',
            'input.value' => $this->attributes['values'][str::snake('customerName')] ?? '',
            'input.required' => true,
            'input.readonly' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Apellido',
            'input.name' => 'customerLastName',
            'input.placeholder' => 'Ingresa el apellido del cliente',
            'input.value' => $this->attributes['values'][str::snake('customerLastName')] ?? '',
            'input.required' => true,
            'input.readonly' => true
        ]);

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Correo Electrónico',
            'input.name' => 'customerEmail',
            'input.placeholder' => 'Ingresa el correo electrónico del cliente',
            'input.value' => $this->attributes['values'][str::snake('customerEmail')] ?? '',
            'input.required' => true,
            'input.readonly' => true
        ]);

        $this->Footer()->addElementInRow(element: Button::Options([
            'button.style' => 'primary',
            'button.name' => 'addressBookSubmit',
            'button.label' => 'Guardar cambios',
            'button.append-attributes' => [ 'class' => ['d-none' => true] ]
        ]), row_options: ['row.replace-attributes' => ['class' => 'col-12 text-end']]);

        $this->Body()->addElement(UxmalComponent::Make('livewire', [
            'options' => [
                'livewire.path' => 'addressbook.form.default-form',
                'livewire.append-data' => [
                    'order_id' => $this->GetValue('order_id')
                ]
            ]
        ]));
    }

}