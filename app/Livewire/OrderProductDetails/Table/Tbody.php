<?php

namespace App\Livewire\OrderProductDetails\Table;

use App\Models\Order;
use App\Models\OrderProductDetail;
use Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class Tbody extends Component
{
    public $table_name;
    public $table_columns;
    public $table_footer;

    public $appended;

    public $increment;

    /**
     * @param $table_name
     * @param $table_columns
     * @param $table_footer
     * @param $appended
     * @return void
     */
    public function mount($table_name, $table_columns, $table_footer, $appended): void
    {
        $this->table_name = $table_name;
        $this->table_columns = $table_columns;
        $this->table_footer = $table_footer;
        $this->appended = $appended;
    }

    /**
     * @return void
     */
    #[On('order-product-details.table.tbody::reload')]
    public function reload(): void
    {
        $this->increment++;
    }


    /**
     * @throws UnknownHashIdConfigParameterException
     * @throws Exception
     */
    public function render(): string
    {
        $this->increment++;

        $table = UxmalComponent::Make('ui.table', ['options' => [
            'table.name' => $this->table_name,
            'table.columns' => $this->table_columns,
            'table.data.model' => OrderProductDetail::class,
            'table.footer' => $this->table_footer
        ]]);

        $order_id = Order::keyFromHashId($this->appended['values']['order_id']);

        $table->DataQuery()
            ->with([
                'product' => function ($query) {
                    $query->select(['id', 'name']);
                },
                'createdby' => function ($query) {
                    $query->select(['id', 'name']);
                },
                'with_digital_art' => function ($query) {
                    $query->with([
                        'material' => function ($query) {
                            $query->select(['id', 'name']);
                        },
                        'digital_art' => function ($query) {
                            $query->select(['id', 'preview_path']);
                        },
                        'print_variation' => function ($query) {
                            $query->select(['id', 'display_name', 'preview_path']);
                        },
                    ]);
                }])
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

        $price = Order::select('price')->findOrFail($order_id)->price;
        $this->dispatch('order-product-details.table.tbody::updated', tfoot: $table->toHtml('tfoot'), price: $price );
        return $table->toHtml('tbody');
    }
}
