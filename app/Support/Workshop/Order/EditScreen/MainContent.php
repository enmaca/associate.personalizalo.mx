<?php

namespace App\Support\Workshop\Order\EditScreen;

use Enmaca\LaravelUxmal\Abstract\ContentBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Form\Input\Checkbox;
use Enmaca\LaravelUxmal\Components\Form\Input\Flatpickr as FlatpickrComponent;
use Enmaca\LaravelUxmal\Components\Ui\Card as CardComponent;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputCheckboxOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputFlatpickrOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\CardOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;

class MainContent extends ContentBlock
{
    /**
     * @throws \Exception
     */
    public function build(): void
    {
        $this->NewContentRow(new RowOptions(
            replaceAttributes: [
                'data-uxmal-order-data' => json_encode([
                    'customer_id' => $this->GetValue('customer_id'),
                    'order_id' => $this->GetValue('order_id')
                ])
            ]));

        $DateButton = UxmalComponent::Make('livewire', [
            'options' => [
                'livewire.path' => 'order.button.delivery-date',
                'livewire.append-data' => [
                    'order_id' => $this->GetValue('order_id')
                ]
            ]
        ])->toHtml();


        $this->ContentRow()->addElement(FlatpickrComponent::Options(new InputFlatpickrOptions(
            name: 'deliveryDate',
            label: '',
            appendAttributes: ['style' => 'display: none'],
            dateFormat: "d M, Y",
            positionElement: '#orderDeliveryDateButtonId'
        )));

        $this->ContentRow()->addElement(MainContent\ClientCard::Object(
            values: $this->GetValues(),
            options: [
                'card.header' => 'Datos Cliente/Entrega',
                'card.header.right' => $DateButton,
                'card.body' => null,
                'card.footer' => null,
                'card.style' => 'primary',
                'card.name' => 'clientCard'
            ]));



        $productCardPriceButton = Button::Options(new ButtonOptions(
            label: '---',
            name: 'productCardPriceButton',
            style: 'info',
            size: 'sm'
        ));

        $this->ContentRow()->addElement(MainContent\ProductCard::Object(
            values: $this->GetValues(),
            options: [
                'card.header' => 'Productos',
                'card.header.right' => $productCardPriceButton->toHtml(),
                'card.body' => null,
                'card.footer' => null,
                'card.style' => 'info',
                'card.name' => 'productCard'
            ]));

        $dynamicCardPriceButton = Button::Options(new ButtonOptions(
            label: '---',
            name: 'dynamicCardPriceButton',
            style: 'warning',
            size: 'sm'
        ));

        $this->ContentRow()->addElement(MainContent\DynamicCard::Object(
            values: $this->GetValues(),
            options: [
                'card.header' => 'Productos Dinámicos',
                'card.header.right' => $dynamicCardPriceButton->toHtml(),
                'card.body' => null,
                'card.footer' => null,
                'card.style' => 'warning',
                'card.name' => 'dynamicCard'
            ]));

        $paymentCardPayedAmountButton = Button::Options(new ButtonOptions(
            label: '---',
            name: 'paymentCardPayedAmountButton',
            style: 'dark',
            size: 'sm'
        ));

        $paymentCardTotalPriceButton = Button::Options(new ButtonOptions(
            label: '---',
            name: 'paymentCardTotalPriceButton',
            style: 'light',
            size: 'sm'
        ));
        $this->ContentRow()->addElement(MainContent\PaymentCard::Object(
            values: $this->GetValues(),
            options: [
                'card.header' => 'Información de Pago',
                'card.header.right' => $paymentCardPayedAmountButton->toHtml().'&nbsp;'.$paymentCardTotalPriceButton->toHtml(),
                'card.body' => null,
                'card.footer' => null,
                'card.style' => 'dark',
                'card.name' => 'paymentCard'
            ]));
    }
}

