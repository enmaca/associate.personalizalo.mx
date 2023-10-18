<?php

namespace App\Support\Uxmal\Products;

use App\Models\Product;
use Enmaca\LaravelUxmal\Uxmal;
class SelectByName extends \Enmaca\LaravelUxmal\Abstract\SelectTomSelect
{

    /**
     * @return void
     * @throws \Exception
     */
    public function build(): void
    {
        $customers = Product::select([
            'id',
            'title',
            'sku'
        ])
            ->orderBy('created_at', 'desc')
            ->take(25)->get();

        $items = [];

        foreach ($customers as $customer)
            $items[$customer->hashId] = "{$customer->title} ({$customer->sku})";


        $this->_content = Uxmal::Component('form.select.tomselect', [
            'options' => [
                'tomselect.name' => 'OrderProductAdd',
                'tomselect.label' => 'Agregar Producto',
                'tomselect.placeholder' => 'Buscar producto...',
                'tomselect.load-url' => '/products/search_tomselect?context=default',
                'tomselect.options' => $items,
                'tomselect.allow-empty-option' => true,
                'tomselect.event-change-handler' => 'onChangeSelectedProductToAdd'
            ]
        ]);
    }

    /**
     * @param string $query
     * @return array
     */
    public function search(string $query): array
    {
        $customers = Product::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('sku', 'like', "%{$query}%")
            ->select([
                'id',
                'title',
                'sku'
            ])
            ->get();

        $items = [];

        foreach ($customers as $customer) {
            $items[] = [
                'value' => $customer->hashId,
                'label' => "{$customer->title} ({$customer->sku})"
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