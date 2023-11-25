<?php

namespace App\Support\Workshop\OrderProductDynamicDetails;

use App\Models\Order;
use App\Models\OrderProductDynamic;
use Enmaca\LaravelUxmal\Block\SelectTomSelectBlock;
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
        $opd_data = OrderProductDynamic::where('order_id', $order_id)->get();
        $items = [];

        foreach ($opd_data as $opd)
            $items[$opd->hashId] = "{$opd->description}";

        $this->_content = UxmalComponent::Make('form.select.tomselect', [
            'options' => [
                'tomselect.label' => 'Productos dinamicos',
                'tomselect.name' => 'cardOrderDynamicProductSelect',
                'tomselect.placeholder' => 'Buscar por Descripcion...',
                'tomselect.load-url' => '/orders/' . $hashed_order_id . '/search_dynamic_products?context=default',
                'tomselect.options' => $items,
                'tomselect.allow-empty-option' => true
            ]
        ]);
    }

    /**
     * @param string $query
     * @return array
     */
    public function search(string $query = ''): array
    {
        $order_id = $this->GetValue('order_id');
        if (is_string($order_id))
            $order_id = Order::keyFromHashId($order_id);

        $opd_data = OrderProductDynamic::where('order_id', $order_id)
            ->select([
                'id',
                'description',
                'price'
            ])
            ->get();

        $items = [];

        foreach ($opd_data as $opd) {
            $items[] = [
                'value' => $opd->hashId,
                'label' => "{$opd->description}"
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