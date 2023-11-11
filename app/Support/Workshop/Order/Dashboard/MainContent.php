<?php

namespace App\Support\Workshop\Order\Dashboard;

use \Enmaca\LaravelUxmal\Components\Form\Button;

class MainContent extends \Enmaca\LaravelUxmal\Abstract\ContentBlock
{
    /**
     * @throws \Exception
     */
    public function build(): void
    {
        $this->ContentAddRow(
            row_options: [
                'row.append-attributes' => [
                    'data-uxmal-dashboard-order' => json_encode([]),
                    'class' => [
                        'row gy-4' => true
                    ]
                ]
            ],
            element: Button::Options([
                'button.name' => 'orderHome',
                'button.type' => 'normal',
                'button.style' => 'primary',
                'button.onclick' => 'createOrder()',
                'button.label' => 'Crear Pedido'
            ]));
    }
}