<?php

namespace App\Livewire\OrderProductDynamicDetails\Table;

use Livewire\Component;

class Tbody extends Component
{
    private $table_name;
    private $table_columns;
    private $table_footer;

    public function mount($table_name, $table_columns, $table_footer){
        $this->table_name = $table_name;
        $this->table_columns = $table_columns;
        $this->table_footer = $table_footer;
    }
    public function render()
    {
        $table = \Enmaca\LaravelUxmal\Uxmal::Component('ui.table', ['options' => [
            'table.name' => $this->table_name,
            'table.columns' => $this->table_columns,
            'table.data.model' => \App\Models\OrderProductDynamicDetails::class,
            'table.footer' => $this->table_footer
        ]]);

        $table->DataQuery()
            ->with(['related', 'createdby'])
            ->whereHas('order_product_dynamic', function ($query) {
                $query->where('order_id', 249);
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

        return $table->toHtml('tbody');

    }
}
