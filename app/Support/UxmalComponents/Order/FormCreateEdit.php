<?php

namespace App\Support\UxmalComponents\Order;

use Enmaca\LaravelUxmal\Uxmal;
use Illuminate\Support\Str;

class FormCreateEdit extends \Enmaca\LaravelUxmal\Abstract\Form
{
    public function build()
    {
        $this->attributes['values'] ??= [];

        $main_card = FormCreateEdit\ClientCard::Object([
            'values' => $this->attributes['values'],
            'options' => [
                'card.header' => 'Datos Generales/Cliente',
                'card.body' => null,
                'card.footer' => 'Agregar Boton de Editar',
                'card.border.style' => 'primary'
            ]
        ]);

        $this->Row(true, $main_card);

        $delivery_card = FormCreateEdit\DeliveryCard::Object([
            'options' => [
                'card.header' => 'Dirección de Entrega/Estatus de Entrega',
                'card.body' => null,
                'card.footer' => '',
                'card.border.style' => 'success'
            ]
        ]);

        $this->Row(true, $delivery_card);

        $delivery_card = FormCreateEdit\ProductCard::Object([
            'options' => [
                'card.header' => 'Productos',
                'card.body' => null,
                'card.footer' => '',
                'card.border.style' => 'info'
            ]
        ]);

        $this->Row(true, $delivery_card);

        $delivery_card = FormCreateEdit\DynamicCard::Object([
            'options' => [
                'card.header' => 'Costos Directos',
                'card.body' => null,
                'card.footer' => '',
                'card.border.style' => 'warning'
            ]
        ]);

        $this->Row(true, $delivery_card);

        $delivery_card = FormCreateEdit\PaymentCard::Object([
            'options' => [
                'card.header' => 'Información de Pago',
                'card.body' => null,
                'card.footer' => '',
                'card.border.style' => 'dark'
            ]
        ]);

        $this->Row(true, $delivery_card);
    }
}

