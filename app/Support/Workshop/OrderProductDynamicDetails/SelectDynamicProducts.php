<?php

namespace App\Support\Workshop\OrderProductDynamicDetails;

use App\Models\Order;
use App\Models\OrderProductDynamic;
use Enmaca\LaravelUxmal\Abstract\SelectTomSelectBlock;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class SelectDynamicProducts extends SelectTomSelectBlock
{

    /**
     * @return void
     * @throws Exception
     */
    public function build(): void
    {
        $hashed_order_id = $this->GetValue('order_id');
        $order_id = Order::keyFromHashId($hashed_order_id);
        $customers = OrderProductDynamic::where('order_id', $order_id)->take(25)->get();
        $items = [];

        foreach( $customers as $customer )
            $items[$customer->hashId] = "{$customer->name} {$customer->last_name} [{$customer->mobile}] ({$customer->email})";

        $this->_content = UxmalComponent::Make('form.select.tomselect', [
            'options' => [
                'tomselect.label' => 'Productos dinamicos',
                'tomselect.name' => 'orderProductDynamicDetails',
                'tomselect.placeholder' => 'Buscar por Descripcion...',
                'tomselect.load-url' => '/order/search_dynamic_products_tomselect?context=default',
                'tomselect.options' => $items,
                'tomselect.allow-empty-option' => true
            ]
        ]);
    }

    /**
     * @param string $query
     * @return array
     */
    public function search(string $query): array
    {
        $order_id = $this->GetValue('order_id');
        $opdd = OrderProductDynamic::where('order_id', $order_id)
            ->select([
                'id',
                'description',
                'price'
            ])
            ->get();

        $items = [];

        foreach ($opdd as $_opdd) {
            $price = round($_opdd->price, 2);
            $items[] = [
                'value' => $_opdd->hashId,
                'label' => "{$_opdd->description} (\${$price})"
            ];
        }

        return [
            'incomplete_results' => false,
            'items' => $items,
            'total_count' => count($items)
        ];
    }

    /**
     * @param mixed $data
     * @return void
     */
    public function create(mixed $data): void
    {
    }
}