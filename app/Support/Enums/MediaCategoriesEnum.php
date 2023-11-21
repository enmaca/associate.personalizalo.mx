<?php

namespace App\Support\Enums;

/**
 * 'catalog_products','catalog_materials','sales_lead','order_product_dynamic'
 */
enum MediaCategoriesEnum: string
{
    case Products = 'catalog_products';
    case Materials = 'catalog_materials';
    case SalesLead = 'sales_lead';
    case OPD = 'order_product_dynamic';
    case OrderProduct = 'order_product';

    public function label(): string
    {
        return match ($this) {
            self::Products => 'Productos',
            self::Materials => 'Materiales',
            self::SalesLead => 'Cotizaciones',
            self::OPD => 'Pedido Producto dinámico (referencia)',
            self::OrderProduct => 'Pedido Producto (referencia)'
        };
    }
}