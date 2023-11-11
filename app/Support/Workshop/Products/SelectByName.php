<?php

namespace App\Support\Workshop\Products;

use App\Models\Product;
use Enmaca\LaravelUxmal\UxmalComponent;
class SelectByName extends \Enmaca\LaravelUxmal\Abstract\SelectTomSelectBlock
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

        $aggregate = [];
        if (isset($this->attributes['options']['event-change-handler']))
            $aggregate['tomselect.event-change-handler'] = $this->attributes['options']['event-change-handler'];

        $this->_content = UxmalComponent::Make('form.select.tomselect', [
            'options' => [
                'tomselect.label' => 'Producto',
                'tomselect.name' => 'OrderProductAdd',
                'tomselect.placeholder' => 'Seleccionar...',
                'tomselect.load-url' => '/products/search_tomselect?context=default',
                'tomselect.options' => $items,
                'tomselect.allow-empty-option' => true
            ] + $aggregate
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