<?php

namespace App\Support\Workshop\AddressBook;

use App\Models\MexDistricts;
use App\Models\MexMunicipalities;
use App\Models\MexState;
use Enmaca\LaravelUxmal\Abstract\SelectTomSelectBlock;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class SelectMexStates extends SelectTomSelectBlock
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
                ->with('municipalities.state')
                ->where('postal_code', $zip_code)
                ->select([
                    'id',
                    'name',
                    'municipality_id'
                ])
                ->get();

            $items[''] = 'Selecciona la colonia...';

            foreach ($districts as $district)
                $items[$district->municipalities->state->hashId] = $district->municipalities->state->name;

        } else {
            $items = [];
        }

        if( is_int($this->GetValue('state_id')) )
            $state_hashid = MexState::select('id')->findOrFail($this->GetValue('state_id'))->hashId;
        else if (is_string($this->GetValue('state_id')))
            $state_hashid = $this->GetValues('state_id');

        $this->_content = UxmalComponent::Make('form.select.tomselect', [
            'options' => [
                    'tomselect.label' => 'Estado (MX)',
                    'tomselect.name' => 'mexState',
                    'tomselect.placeholder' => 'Seleciona el estado...',
                    'tomselect.load-url' => '/address_book/mex_state/search_tomselect',
                    'tomselect.options' => $items,
                    'tomselect.required' => true,
                    'tomselect.value' => $state_hashid ?? false,
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
            ->with('municipalities.state')
            ->where('postal_code', $postal_code)
            ->select([
                'id',
                'name',
                'municipality_id'
            ])
            ->get();

        foreach ($districts as $district)
            $_items[$district->municipalities->state->hashId] = $district->municipalities->state->name;

        $items = [['value' => '', 'label' => 'Selecciona el estado...']];
        foreach ($_items as $value => $label)
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
        $states = MexState::query()
            ->where('name', $query)
            ->select([
                'id',
                'name',
                'city_name'
            ])
            ->get();

        $items = [['value' => '', 'label' => 'Selecciona el estado...']];

        foreach ($states as $state) {
            $items[] = [
                'value' => $state->hashId,
                'label' => $state->name . (!empty($state->city_name) ? ' (' . $state->city_name . ')' : '')
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