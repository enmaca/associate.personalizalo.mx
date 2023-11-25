<?php

namespace App\Support\Workshop\Order\EditScreen;

use Enmaca\LaravelUxmal\Block\ContentBlock;
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
            options: CardOptions::Make()
                ->name('clientCard')
                ->header('Datos Cliente/Entrega')
                ->headerRight($DateButton)
                ->style('primary')->toArray()
        ));



        $productCardPriceButton = Button::Options(new ButtonOptions(
            name: 'productCardPriceButton',
            label: '---',
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
            name: 'dynamicCardPriceButton',
            label: '---',
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
            name: 'paymentCardPayedAmountButton',
            label: '---',
            style: 'dark',
            size: 'sm'
        ));

        $paymentCardTotalPriceButton = Button::Options(new ButtonOptions(
            name: 'paymentCardTotalPriceButton',
            label: '---',
            style: 'light',
            size: 'sm'
        ));
        $this->ContentRow()->addElement(MainContent\PaymentCard::Object(
            values: $this->GetValues(),
            options: [
                'card.header' => 'Información de Pago',
                'card.header.right' => $paymentCardPayedAmountButton->toHtml() . '&nbsp;' . $paymentCardTotalPriceButton->toHtml(),
                'card.body' => null,
                'card.footer' => null,
                'card.style' => 'dark',
                'card.name' => 'paymentCard'
            ]));
    }
}

