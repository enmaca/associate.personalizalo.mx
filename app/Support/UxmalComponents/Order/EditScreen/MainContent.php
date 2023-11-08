<?php

namespace App\Support\UxmalComponents\Order\EditScreen;

class MainContent extends \Enmaca\LaravelUxmal\Abstract\Content
{
    public function build(): void
    {
        $main_div = $this->Row(options: [
            'row.append-attributes' => [
                'data-uxmal-order-data' => json_encode([
                    'customer_id' => $this->GetValue('customer_id'),
                    'order_id' => $this->GetValue('order_id')
                ]),
                'class' => [
                    'row gy-4' => true
                ]
            ]
        ]);
        $this->attributes['values'] ??= [];

        $DateButton = \Enmaca\LaravelUxmal\Uxmal::Component('livewire', [
            'options' => [
                'livewire.path' => 'order.button.delivery-date',
                'livewire.append-data' => [
                    'order_id' => $this->GetValue('order_id')
                ]
            ]
        ])->toHtml();

        $main_card = $main_div->addElement(\Enmaca\LaravelUxmal\Components\Ui\Card::Options([
            'card.name' => 'orderCard',
            'card.header' => 'Pedido ' . $this->GetValue('order_code'),
            'card.header.right' => $DateButton,
            'card.body' => null,
            'card.footer' => '&nbsp;'
        ]));


        $main_card->Body()->addElement(\Enmaca\LaravelUxmal\Components\Form\Input\Flatpickr::Options([
            'input.type' => 'flatpickr',
            'flatpickr.label' => null,
            'flatpickr.name' => 'deliveryDate',
            'flatpickr.append-attributes' => ['style' => 'display: none'],
            'flatpickr.date-format' => "d M, Y",
            'flatpickr.positionElement' => '#orderDeliveryDateButtonId'
        ]));


        $main_card->Body()->addElement(MainContent\ClientCard::Object(values: $this->GetValues(), options: [
            'card.header' => 'Datos Cliente/Entrega',
            'card.body' => null,
            'card.footer' => null,
            'card.style' => 'primary',
            'card.name' => 'clientCard'
        ]));


        $main_card->Body()->addElement(MainContent\MfgCard::Object(values: $this->GetValues(), options: [
            'card.header' => 'Dirección de Entrega/Estatus de Entrega',
            'card.body' => null,
            'card.footer' => null,
            'card.style' => 'success',
            'card.name' => 'deliveryCard'
        ]));


        $main_card->Body()->addElement(MainContent\ProductCard::Object(values: $this->GetValues(), options: [
            'card.header' => 'Productos',
            'card.body' => null,
            'card.footer' => null,
            'card.style' => 'info',
            'card.name' => 'productCard'
        ]));

        $main_card->Body()->addElement(MainContent\DynamicCard::Object(values: $this->GetValues(), options: [
            'card.header' => 'Costos Directos',
            'card.body' => null,
            'card.footer' => null,
            'card.style' => 'warning',
            'card.name' => 'dynamicCard'
        ]));

        $main_card->Body()->addElement(MainContent\PaymentCard::Object(values: $this->GetValues(), options: [
            'card.header' => 'Información de Pago',
            'card.body' => null,
            'card.footer' => '',
            'card.style' => 'dark',
            'card.name' => 'paymentCard'
        ]));

    }
}

