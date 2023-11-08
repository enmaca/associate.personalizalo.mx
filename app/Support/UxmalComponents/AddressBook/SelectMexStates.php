<?php

namespace App\Support\UxmalComponents\AddressBook;

use App\Models\MexDistricts;
use App\Models\MexState;
use Enmaca\LaravelUxmal\Abstract\SelectTomSelectBlock;
use Enmaca\LaravelUxmal\UxmalComponent;

class SelectMexStates extends SelectTomSelectBlock
{

    /**
     * @return void
     * @throws \Exception
     */
    public function build(): void
    {
        $uxmal = new UxmalComponent();

        //$states = MexState::take(25)->get();

        /*
        foreach( $states as $state )
            $items[$state->hashId] = $state->name;
*/

        $items = [];
        $this->_content = $uxmal->component('form.select.tomselect', [
            'options' => [
                'tomselect.label' => 'Estado (MX)',
                'tomselect.name' => 'mexState',
                'tomselect.placeholder' => 'Seleciona el estado...',
                'tomselect.load-url' => '/address_book/mex_state/search_tomselect',
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

        $items = [[ 'value' => '', 'label' => 'Selecciona el estado...' ]];
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
        $states = MexState::query()
            ->where('name', $query)
            ->select([
                'id',
                'name',
                'city_name'
            ])
            ->get();

        $items = [[ 'value' => '', 'label' => 'Selecciona el estado...' ]];

        foreach ($states as $state) {
            $items[] = [
                'value' => $state->hashId,
                'label' => $state->name.(!empty($state->city_name) ? ' ('.$state->city_name.')' : '')
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