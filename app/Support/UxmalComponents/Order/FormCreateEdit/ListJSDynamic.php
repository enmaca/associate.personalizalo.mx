<?php

namespace App\Support\UxmalComponents\Order\FormCreateEdit;

class ListJSDynamic extends \Enmaca\LaravelUxmal\Abstract\ListJs
{
    public function build(): void
    {

        $this->_content->setColumns([
            'hashId' => [
                'tbhContent' => 'checkbox-all',
                'type' => 'primaryKey',
                'handler' =>  \App\Support\UxmalComponents\OrderProductDynamicDetails\TbHandler\Id::class
            ],
            'related.name' => [
                'tbhContent' => 'Material/Concepto'
            ],
            'quantity' => [
                'tbhContent' => 'Cantidad',
            ],
            'cost' => [
                'tbhContent' => 'Costo'
            ],
            'taxes' => [
                'tbhContent' => 'Impuestos'
            ],
            'profit_margin' => [
                'tbhContent' => 'Margen',
                'handler' => \App\Support\UxmalComponents\OrderProductDynamicDetails\TbHandler\ProfitMargin::class
            ],
            'subtotal' => [
                'tbhContent' => 'Subtotal'
            ],
            'createdby.name' => [
                'tbhContent' => 'Creado'
            ]
        ]);


        $this->_content->Model(\App\Models\OrderProductDynamicDetails::class)
        ->with(['related', 'createdby'])
        ->whereHas('order_product_dynamic', function ($query){
            $query->where('order_id', $this->attributes['values']['order_id']);})
        ->select([
            'id',
            'order_product_dynamic_id',
            'reference_type',
            'reference_id',
            'quantity',
            'cost',
            'taxes',
            'profit_margin',
            'subtotal',
            'created_by']);

        $buttons_row = new \Enmaca\LaravelUxmal\Uxmal();

        switch ($this->attributes['context']) {
            case 'orderhome':
                $buttons_row->component('form.button', [
                    'options' => [
                        'button.name' => 'orderHome',
                        'button.type' => 'normal',
                        'button.style' => 'primary',
                        'button.onclick' => 'createOrder()',
                        'button.label' => 'Crear Pedido'
                    ]
                ]);
                break;
            default:
                break;
        }

        $this->_content->setTopButtons($buttons_row->toArray());
        $this->_content->setPagination(15);

        $this->_content->setSearch(true, ['placeholder' => 'Buscar...']);
    }
}