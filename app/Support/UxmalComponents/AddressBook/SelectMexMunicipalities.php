<?php

namespace App\Support\UxmalComponents\AddressBook;

use App\Models\MexDistricts;
use App\Models\MexMunicipality;

class SelectMexMunicipalities extends \Enmaca\LaravelUxmal\Abstract\SelectTomSelect
{

    /**
     * @return void
     * @throws \Exception
     */
    public function build(): void
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

//        $municipalities = MexMunicipality::take(25)->get();

        $items = [];
/*
        foreach( $municipalities as $municipality )
            $items[$municipality->hashId] = $municipality->name;
*/

        $this->_content = $uxmal->component('form.select.tomselect', [
            'options' => [
                'tomselect.label' => 'Ciudad (MX)',
                'tomselect.name' => 'mexMunicipalities',
                'tomselect.placeholder' => 'Selecciona la ciudad...',
                'tomselect.load-url' => '/address_book/mex_municipality/search_tomselect',
                'tomselect.options' => $items,
                'tomselect.allow-empty-option' => true
            ]
        ]);
    }

    /**
     * @param string $query
     * @return array
     */
    public function searchByPostalCode(mixed $postal_code): array
    {
        $districts = MexDistricts::query()
            ->with('municipalities')
            ->where('postal_code', $postal_code)
            ->select([
                'id',
                'name',
                'municipality_id'
            ])
            ->get();

        $_items = [];

        foreach ($districts as $district)
            $_items[$district->municipalities->hashId] = $district->municipalities->name.(!empty($district->municipalities->city_name) ? ' ('.$district->municipalities->city_name.')' : '');

        $items = [];
        foreach( $_items as $value => $label)
            $items[] = [
                'value' => $value,
                'label' => $label
            ];

        return [
            'incomplete_results' => false,
            'items' => $items,
            'total_count' => count($items)
        ];
    }

    /**
     * @param string $query
     * @return array
     */
    public function search(string $query): array
    {
        $municipalities = MexMunicipality::query()
            ->where('name', $query)
            ->select([
                'id',
                'name',
                'city_name'
            ])
            ->get();

        $items = [];

        foreach ($municipalities as $municipality) {
            $items[] = [
                'value' => $municipality->hashId,
                'label' => $municipality->name.(!empty($municipality->city_name) ? ' ('.$municipality->city_name.')' : '')
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