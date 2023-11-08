<?php

namespace App\Livewire\OrderProductDetails\Table;

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
        $table = \Enmaca\LaravelUxmal\UxmalComponent::Make('ui.table', ['options' => [
            'table.name' => $this->table_name,
            'table.columns' => $this->table_columns,
            'table.data.model' => \App\Models\OrderProductDetail::class,
            'table.footer' => $this->table_footer
        ]]);

        $order_id = Order::keyFromHashId($this->appended['values']['order_id']);

        $table->DataQuery()
            ->with([
                'product' => function ($query) { $query->select(['id', 'name']); },
                'createdby' => function ($query) { $query->select(['id', 'name']); },
                'with_digital_art' => function ($query) { $query->with([
                    'material' => function ($query) { $query->select(['id', 'name']); },
                    'digital_art' => function ($query) { $query->select(['id', 'preview_path']); },
                    'print_variation' => function ($query) { $query->select(['id', 'display_name', 'preview_path']); },
                ]); }])
            ->whereHas('order', function ($query) use ($order_id) {
                $query->where('order_id', $order_id);
            })
            ->select([
                'id',
                'catalog_product_id',
                'order_id',
                'quantity',
                'price',
                'taxes',
                'subtotal',
                'created_by'])->get();

        $this->dispatch('order-product-details.table.tbody::updated', tfoot: $table->toHtml('tfoot'));
        return $table->toHtml('tbody');
    }
}
