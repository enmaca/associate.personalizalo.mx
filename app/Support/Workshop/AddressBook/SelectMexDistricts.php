<?php

namespace App\Support\Workshop\AddressBook;

use App\Models\MexDistricts;
use Enmaca\LaravelUxmal\Abstract\SelectTomSelectBlock;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class SelectMexDistricts extends SelectTomSelectBlock
{

    /**
     * @return void
     * @throws Exception
     */
    public function build(): void
    {
        $items = [];
        $this->attributes['options'] ??= [];

        $this->_content = UxmalComponent::Make('form.select.tomselect', [
            'options' => [
                    'tomselect.label' => 'Colonia (MX)',
                    'tomselect.name' => 'mexDistrict',
                    'tomselect.placeholder' => 'Selecciona la colonia...',
                    'tomselect.load-url' => '/address_book/mex_district/search_tomselect',
                    'tomselect.options' => $items,
                    'tomselect.required' => true,
                ] + $this->attributes['options']
        ]);
    }

    /**
     * @param string $postal_code
     * @return array
     */
    public function searchByPostalCode(string $postal_code): array
    {
        $districts = MexDistricts::query()
            ->where('postal_code', $postal_code)
            ->select([
                'id',
                'name',
                'postal_code'
            ])
            ->get();

        $items = [['value' => '', 'label' => 'Selecciona la colonia...']];

        foreach ($districts as $district) {
            $items[] = [
                'value' => $district->hashId,
                'label' => $district->name
            ];
        }

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
        $districts = MexDistricts::query()
            ->where('name', $query)
            ->select([
                'id',
                'name',
                'postal_code'
            ])
            ->get();

        $items = [['value' => '', 'label' => 'Selecciona la colonia...']];

        foreach ($districts as $district) {
            $items[] = [
                'value' => $district->hashId,
                'label' => $district->name
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