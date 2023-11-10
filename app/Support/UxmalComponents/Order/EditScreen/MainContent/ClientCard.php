<?php

namespace App\Support\UxmalComponents\Order\EditScreen\MainContent;

use App\Support\UxmalComponents\AddressBook\DefaultForm as AddressBookDefaultForm;
use Carbon\Carbon;
use Enmaca\LaravelUxmal\Abstract\CardBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
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

        $this->BodyInput([
            'input.type' => 'text',
            'input.label' => 'Indicaciones de Entrega',
            'input.name' => 'deliveryInstructions',
            'input.placeholder' => 'Instrucciones de entrega',
            'input.value' => $this->attributes['values'][str::snake('deliveryInstructions')] ?? '',
            'input.readonly' => $this->attributes['options']['customer.card.readonly'],
            'input.required' => true
        ]);

        $this->Footer()->addElementInRow(element: Button::Options([
            'button.style' => 'primary',
            'button.name' => 'addressBookSubmit',
            'button.label' => 'Guardar cambios',
            'button.append-attributes' => [ 'class' => ['d-none' => true] ]
        ]), row_options: ['row.replace-attributes' => ['class' => 'col-12 text-end']]);

        $this->Body()->addElement(new AddressBookDefaultForm(['options' => ['form.id' => 'deliveryData', 'form.action' => '/order/delivery_data']]));
    }

}