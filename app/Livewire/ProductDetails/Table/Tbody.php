<?php

namespace App\Livewire\ProductDetails\Table;

use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;

class Tbody extends Component
{
    public $table_name;
    public $table_columns;
    public $table_footer;

    public $appended;

    public function mount($table_name, $table_columns, $table_footer, $appended){
        $this->table_name = $table_name;
        $this->table_columns = $table_columns;
        $this->table_footer = $table_footer;
        $this->appended = $appended;
    }

    #[On('order-product-details.table.tbody::reload')]
    public function reload(){

    }


    public function render()
    {
        $table = \Enmaca\LaravelUxmal\Uxmal::Component('ui.table', ['options' => [
            'table.name' => $this->table_name,
            'table.columns' => $this->table_columns,
            'table.data.model' => \App\Models\OrderProductDetail::class,
            'table.footer' => $this->table_footer
        ]]);

        $order_id = Order::keyFromHashId($this->appended['values']['order_id']);

        $table->DataQuery()
            ->with(['related', 'createdby'])
            ->whereHas('order', function ($query) use ($order_id) {
                $query->where('order_id', $order_id);
            })
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
                'created_by'])->get();

        //dump($table->toHtml('tbody'));
        //dd($table);

        $this->dispatch('order-product-dynamic-details.table.tbody::updated', tfoot: $table->toHtml('tfoot'));
        return $table->toHtml('tbody');
    }
}
