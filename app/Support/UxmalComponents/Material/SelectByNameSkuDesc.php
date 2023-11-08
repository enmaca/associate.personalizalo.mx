<?php

namespace App\Support\UxmalComponents\Material;

use App\Models\Material;

class SelectByNameSkuDesc extends \Enmaca\LaravelUxmal\Abstract\SelectTomSelectBlock
{

    /**
     * @return void
     * @throws \Exception
     */
    public function build(): void
    {
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();

        $materials = Material::orderBy('created_at', 'desc')->take(25)->get();

        $aggregate = [];

        if(isset($this->attributes['options']['event-change-handler']))
            $aggregate['tomselect.event-change-handler'] = $this->attributes['options']['event-change-handler'];

        $items = [];

        foreach( $materials as $material )
            $items[$material->hashId] = "{$material->name}";

        $this->_content = $uxmal->component('form.select.tomselect', [
            'options' => [
                'tomselect.label' => 'Material Directo',
                'tomselect.name' => 'materialSelected',
                'tomselect.placeholder' => 'Seleccionar...',
                'tomselect.load-url' => route('material_search_tomselect', [ 'context' => 'by_name_sku_desc']),
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
            ->select([
                'id',
                'name'
            ])
            ->get();

        $items = [];

        foreach ( $materials as $material ){
            $items[] = [
                'value' => $material->hashId,
                'label' => $material->name
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