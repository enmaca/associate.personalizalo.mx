<?php

namespace App\Support\Uxmal\Customer;

use App\Models\Customer;

class SelectByNameMobileEmail extends \Enmaca\LaravelUxmal\Abstract\SelectTomSelect
{

    /**
     * @return void
     * @throws \Exception
     */
    public function build(): void
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $customers = Customer::orderBy('created_at', 'desc')->take(25)->get();

        $items = [];

        foreach( $customers as $customer )
            $items[$customer->hashId] = "{$customer->name} {$customer->last_name} [{$customer->mobile}] ({$customer->email})";


        $this->_content = $uxmal->component('form.select.tomselect', [
            'options' => [
                'tomselect.name' => 'customerId',
                'tomselect.label' => 'Buscar Cliente',
                'tomselect.placeholder' => 'Buscar por nombre, telefono o email...',
                'tomselect.load-url' => '/customer/search_tomselect?context=by_name_mobile_email',
                'tomselect.options' => $items,
                'tomselect.allow-empty-option' => true,
                'tomselect.event-change-handler' => 'onChangeSelectedByNameMobileEmail'
            ]
        ]);
    }

    /**
     * @param string $query
     * @return array
     */
    public function search(string $query): array
    {
        $customers = Customer::query()
            ->where('mobile', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->select([
                'id',
                'name',
                'last_name',
                'mobile',
                'email'
            ])
            ->get();

        $items = [];

        foreach ($customers as $customer) {
            $items[] = [
                'value' => $customer->hashId,
                'label' => "{$customer->name} {$customer->last_name} [{$customer->mobile}] ({$customer->email})"
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