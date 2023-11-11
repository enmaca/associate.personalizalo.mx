<?php
namespace App\Support\Workshop\Order\EditScreen;

use Enmaca\LaravelUxmal\Abstract\ContentBlock;
use Enmaca\LaravelUxmal\Components\Form\Input\Flatpickr as FlatpickrComponent;
use Enmaca\LaravelUxmal\Components\Ui\Card as CardComponent;
use Enmaca\LaravelUxmal\Support\Options\Ui\CardOptions;
use Enmaca\LaravelUxmal\UxmalComponent;

class MainContent extends ContentBlock
{
    /**
     * @throws \Exception
     */
    public function build(): void
    {
        $main_div = $this->ContentAddRow(row_options: [
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

        $DateButton = UxmalComponent::Make('livewire', [
            'options' => [
                'livewire.path' => 'order.button.delivery-date',
                'livewire.append-data' => [
                    'order_id' => $this->GetValue('order_id')
                ]
            ]
        ])->toHtml();

        $main_card = $main_div->addElement(CardComponent::Options(
            new CardOptions(
                name: 'orderCard',
                header: 'Pedido ' . $this->GetValue('order_code'),
                headerRight: $DateButton,
                body: null,
                footer: '&nbsp;'
            )
        ));


        $main_card->Body()->addElement(FlatpickrComponent::Options([
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
            'card.header' => 'Datos de Manufactura',
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

