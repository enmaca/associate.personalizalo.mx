<?php

namespace App\Support\Workshop\Order\Dashboard;

use Enmaca\LaravelUxmal\Block\ContentBlock;
use \Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;

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
                ]),
                'class' => [
                    'row gy-4' => true
                ]
            ]));

        $this->ContentRow()->addElement(element: Button::Options(new ButtonOptions(
            label: 'Crear Pedido',
            name: 'orderHome',
            style: 'primary',
            type: 'normal',
            onclick: 'createOrder()'
        )));

    }
}