<?php

namespace App\Livewire\OrderProductDynamicDetails\Table;

use App\Models\Order;
use App\Support\Services\OrderService;
use Livewire\Attributes\On;
use Livewire\Component;

class Tbody extends Component
{
    public $table_name;
    public $table_columns;
    public $table_footer;

    public $increment = 0;

    public $appended;

    public function mount($table_name, $table_columns, $table_footer, $appended){
        $this->table_name = $table_name;
        $this->table_columns = $table_columns;
        $this->table_footer = $table_footer;
        $this->appended = $appended;
    }

    #[On('order-product-dynamic-details.table.tbody::reload')]
    public function reload(): void
    {
        $this->increment++;
    }


    public function render(): string
    {
        $this->increment++;
        $table = \Enmaca\LaravelUxmal\UxmalComponent::Make('ui.table', ['options' => [
            'table.name' => $this->table_name,
            'table.columns' => $this->table_columns,
            'table.data.model' => \App\Models\OrderProductDynamicDetails::class,
            'table.footer' => $this->table_footer
        ]]);

        $order_id = Order::keyFromHashId($this->appended['values']['order_id']);

        $table->DataQuery()
            ->with(['related', 'createdby'])
            ->whereHas('order_product_dynamic', function ($query) use ($order_id) {
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
                'price',
                'created_by'])->get();

        $price = Order::select('price')->findOrFail($order_id)->price;
        $this->dispatch('order-product-dynamic-details.table.tbody::updated', tfoot: $table->toHtml('tfoot'), price: $price );
        return $table->toHtml('tbody');

    }
}
