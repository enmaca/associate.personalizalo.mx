<?php

namespace App\Support\UxmalComponents\Order;

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
                'card.footer' => null,
                'card.style' => 'primary',
                'card.name' => 'clientCard'
            ]
        ]);

        $this->Row(true, $main_card);

        $mfg_card = FormCreateEdit\MfgCard::Object([
            'values' => $this->attributes['values'],
            'options' => [
                'card.header' => 'Dirección de Entrega/Estatus de Entrega',
                'card.body' => null,
                'card.footer' => null,
                'card.style' => 'success',
                'card.name' => 'deliveryCard'
            ]
        ]);

        $this->Row(true, $mfg_card);

        $productCard = FormCreateEdit\ProductCard::Object([
            'values' => $this->attributes['values'],
            'options' => [
                'card.header' => 'Productos',
                'card.body' => null,
                'card.footer' => null,
                'card.style' => 'info',
                'card.name' => 'productCard'
            ]
        ]);

        $this->Row(true, $productCard);

        $dynamicCard = FormCreateEdit\DynamicCard::Object([
            'values' => $this->attributes['values'],
            'options' => [
                'card.header' => 'Costos Directos',
                'card.body' => null,
                'card.footer' => null,
                'card.style' => 'warning',
                'card.name' => 'dynamicCard'
            ]
        ]);

        $this->Row(true, $dynamicCard);

        $paymentCard = FormCreateEdit\PaymentCard::Object([
            'values' => $this->attributes['values'],
            'options' => [
                'card.header' => 'Información de Pago',
                'card.body' => null,
                'card.footer' => '',
                'card.style' => 'dark',
                'card.name' => 'paymentCard'
            ]
        ]);

        $this->Row(true, $paymentCard);
    }
}

