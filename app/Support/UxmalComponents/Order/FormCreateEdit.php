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
                'card.style' => 'primary',
                'card.name' => 'clientCard'
            ]
        ]);

        $this->Row(true, $main_card);

        $delivery_card = FormCreateEdit\DeliveryCard::Object([
            'options' => [
                'card.header' => 'Dirección de Entrega/Estatus de Entrega',
                'card.body' => null,
                'card.footer' => '',
                'card.style' => 'success',
                'card.name' => 'deliveryCard'
            ]
        ]);

        $this->Row(true, $delivery_card);

        $delivery_card = FormCreateEdit\ProductCard::Object([
            'options' => [
                'card.header' => 'Productos',
                'card.body' => null,
                'card.footer' => '',
                'card.style' => 'info',
                'card.name' => 'productCard'
            ]
        ]);

        $this->Row(true, $delivery_card);

        $delivery_card = FormCreateEdit\DynamicCard::Object([
            'options' => [
                'card.header' => 'Costos Directos',
                'card.body' => null,
                'card.footer' => '',
                'card.style' => 'warning'
            ]
        ]);

        $this->Row(true, $delivery_card);

        $delivery_card = FormCreateEdit\PaymentCard::Object([
            'options' => [
                'card.header' => 'Información de Pago',
                'card.body' => null,
                'card.footer' => '',
                'card.style' => 'dark'
            ]
        ]);

        $this->Row(true, $delivery_card);
    }
}

