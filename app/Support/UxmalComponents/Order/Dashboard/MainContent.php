<?php

namespace App\Support\UxmalComponents\Order\Dashboard;

use \Enmaca\LaravelUxmal\Components\Form\Button;

class MainContent extends \Enmaca\LaravelUxmal\Abstract\Content
{
    public function build(): void
    {
        $this->Row(
            options: [
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