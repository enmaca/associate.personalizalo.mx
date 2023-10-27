<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;

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
                    'href' => route('manufacturing_products')
                ]
            ],
            'MANUFACTURA' => [
                [
                    'icon' => 'speedometer',
                    'name' => 'Dashboard',
                    'href' => route('manufacturing_root')
                ],
                [
                    'icon' => 'building-gear',
                    'name' => 'Areas',
                    'href' => route('manufacturing_areas')
                ],
                [
                    'icon' => 'gear',
                    'name' => 'Equipos',
                    'href' => route('manufacturing_devices')
                ],
                [
                'icon' => 'cash',
                'name' => 'Costos Mano de Obra',
                'href' => route('manufacturing_laborcosts')
                ],
                [
                    'icon' => 'postcard',
                    'name' => 'Variación de Impresion',
                    'href' => route('manufacturing_printvariation')
                ]

            ],
            'INVENTARIO' => [
                [
                    'icon' => 'box-arrow-in-down-left',
                    'name' => 'Materiales',
                    'href' => route('material_root')
                ],
                [
                    'icon' => 'bricks',
                    'name' => 'Grupo de Variación',
                    'href' => route('material_variation_group')
                ],
            ],
            'SISTEMA' => [
                [
                    'icon' => 'box-seam',
                    'name' => 'Productos',
                    'href' => route('system_products')
                ],
                [
                    'icon' => 'people',
                    'name' => 'Clientes',
                    'href' => route('system_customers')
                ],
                [
                    'icon' => 'truck',
                    'name' => 'Proveedores',
                    'href' => route('system_suppliers')
                ],
                [
                    'icon' => 'receipt',
                    'name' => 'Impuestos',
                    'href' => route('system_taxes')
                ],
                [
                    'icon' => 'rulers',
                    'name' => 'Unidades de Medida',
                    'href' => route('system_uom')
                ],
                [
                    'icon' => 'person-badge',
                    'name' => 'Usuarios',
                    'href' => route('system_users')
                ],
            ],
            'HERRAMIENTAS' => [
                [
                    'icon' => 'bounding-box',
                    'name' => 'CMYKW',
                    'href' => route('customers')
                ],
                [
                    'icon' => 'boxes',
                    'name' => 'Nesting',
                    'href' => route('customers')
                ]
            ],
        ];
        View::share('menu', $menu);
    }

    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
