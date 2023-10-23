<?php

namespace App\Support\UxmalComponents\Material;

use App\Models\Material;

class SelectByNameSkuDesc extends \Enmaca\LaravelUxmal\Abstract\SelectTomSelect
{

    /**
     * @return void
     * @throws \Exception
     */
    public function build(): void
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $materials = Material::orderBy('created_at', 'desc')->take(25)->get();

        $aggregate = [];

        if(isset($this->attributes['options']['event-change-handler']))
            $aggregate['tomselect.event-change-handler'] = $this->attributes['options']['event-change-handler'];

        $items = [];

        foreach( $materials as $material )
            $items[$material->hashId] = "{$material->name}";

        $this->_content = $uxmal->component('form.select.tomselect', [
            'options' => [
                'tomselect.name' => 'materialSelected',
                'tomselect.placeholder' => 'Buscar por nombre, sku, color, talla...',
                'tomselect.load-url' => '/maerial/search_tomselect?context=by_name_sku_desc',
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
        $materials = Material::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('color', 'like', "%{$query}%")
            ->orWhere('size', 'like', "%{$query}%")
            ->select([
                'id',
                'name',
                'color',
                'sizee'
            ])
            ->get();

        $items = [];

        foreach ( $materials as $material ){
            $items[] = [
                'value' => $material->hashId,
                'label' => "{$material->name}  [{$material->color}::{$material->size}] "
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