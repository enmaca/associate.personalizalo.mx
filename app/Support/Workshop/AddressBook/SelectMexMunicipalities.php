<?php

namespace App\Support\Workshop\AddressBook;

use App\Models\MexDistricts;
use App\Models\MexMunicipalities;
use Enmaca\LaravelUxmal\Abstract\SelectTomSelectBlock;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class SelectMexMunicipalities extends SelectTomSelectBlock
{

    /**
     * @return void
     * @throws Exception
     */
    public function build(): void
    {
        $zip_code = $this->GetValue('zip_code');
        if($zip_code){
            $districts = MexDistricts::query()
                ->with('municipalities')
                ->where('postal_code', $zip_code)
                ->select([
                    'id',
                    'name',
                    'municipality_id'
                ])
                ->get();

            $items[''] = 'Selecciona la colonia...';

            foreach ($districts as $district)
                $items[$district->municipalities->hashId] = $district->municipalities->name.(!empty($district->municipalities->city_name) ? ' ('.$district->municipalities->city_name.')' : '');

        } else {
            $items = [];
        }

        if( is_int($this->GetValue('municipality_id')) )
            $municipality_hashid = MexMunicipalities::select('id')->findOrFail($this->GetValue('municipality_id'))->hashId;
        else if (is_string($this->GetValue('municipality_id')))
            $municipality_hashid = $this->GetValues('municipality_id');

        $this->_content = UxmalComponent::Make('form.select.tomselect', [
            'options' => [
                'tomselect.label' => 'Ciudad (MX)',
                'tomselect.name' => 'mexMunicipalities',
                'tomselect.placeholder' => 'Selecciona la ciudad...',
                'tomselect.load-url' => '/address_book/mex_municipality/search_tomselect',
                'tomselect.options' => $items,
                'tomselect.value' => $municipality_hashid ?? false,
                'tomselect.required' => true
            ]
        ]);
    }

    /**
     * @param string $postal_code
     * @return array
     */
    public function searchByPostalCode(string $postal_code): array
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

        $items = [[ 'value' => '', 'label' => 'Selecciona la ciudad...']];
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
        $municipalities = MexMunicipalities::query()
            ->where('name', $query)
            ->select([
                'id',
                'name',
                'city_name'
            ])
            ->get();

        $items = [[ 'value' => '', 'label' => 'Selecciona la ciudad...']];

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