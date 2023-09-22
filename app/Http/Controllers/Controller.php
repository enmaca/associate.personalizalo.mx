<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $menu = [];

    public function __construct()
    {
        $menu = [
            'VENTA' => [
                [
                    'icon' => 'cart',
                    'name' => 'Pedidos',
                    'href' => route('orders_root')
                ],
                [
                    'icon' => 'box',
                    'name' => 'Products',
                    'href' => route('clients_root')
                ]
            ],
            'MANUFACTURA' => [
                [
                    'icon' => 'box',
                    'name' => 'Productos',
                    'href' => route('clients_root')
                ],
                [
                    'icon' => 'cash',
                    'name' => 'Costos Mano de Obra',
                    'href' => route('clients_root')
                ],
                [
                    'icon' => 'building-gear',
                    'name' => 'Areas',
                    'href' => route('clients_root')
                ],
                [
                    'icon' => 'gear',
                    'name' => 'Equipos',
                    'href' => route('clients_root')
                ]
            ],
            'HERRAMIENTAS' => [
                [
                    'icon' => 'bounding-box',
                    'name' => 'CMYKW',
                    'href' => route('clients_root')
                ],
                [
                    'icon' => 'boxes',
                    'name' => 'Nesting',
                    'href' => route('clients_root')
                ]
            ],
            'INVENTARIO' => [
                [
                    'icon' => 'box-arrow-in-down-left',
                    'name' => 'Materiales',
                    'href' => route('clients_root')
                ],
                [
                    'icon' => 'bricks',
                    'name' => 'Grupo de Variación',
                    'href' => route('clients_root')
                ],
            ],
            'SISTEMA' => [
                [
                    'icon' => 'people',
                    'name' => 'Clientes',
                    'href' => route('clients_root')
                ],
                [
                    'icon' => 'truck',
                    'name' => 'Proveedores',
                    'href' => route('clients_root')
                ],
                [
                    'icon' => 'receipt',
                    'name' => 'Impuestos',
                    'href' => route('clients_root')
                ],
                [
                    'icon' => 'rulers',
                    'name' => 'Unidades de Medida',
                    'href' => route('clients_root')
                ],
                [
                    'icon' => 'person-badge',
                    'name' => 'Usuarios',
                    'href' => route('clients_root')
                ],
            ]
        ];
        View::share('menu', $menu);
    }
}
