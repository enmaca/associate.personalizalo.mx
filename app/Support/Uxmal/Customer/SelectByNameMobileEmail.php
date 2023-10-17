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

        $items = $customers->mapWithKeys(function ($customer) {
            return [$customer['id']  => "{$customer['name']} {$customer['last_name']} [{$customer['mobile']}] ({$customer['email']})"];
        });


        $this->_content = $uxmal->component('form.select.tomselect', [
            'options' => [
                'tomselect.name' => 'customerId',
                'tomselect.label' => 'Buscar Cliente',
                'tomselect.placeholder' => 'Buscar por nombre, telefono o email...',
                'tomselect.load-url' => '/customer/search_tomselect?context=by_name_mobile_email',
                'tomselect.options' => $items->toArray(),
                'tomselect.allow-empty-option' => true
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

        $items = $customers->mapWithKeys(function ($customer) {
            return [
                'value' => $customer['id'],
                'label' => "{$customer['name']} {$customer['last_name']} [{$customer['mobile']}] ({$customer['email']})"
            ];
        });

        foreach ($customers->toArray() as $customer) {
            $items[] = [
                'value' => $customer['id'],
                'label' => "{$customer['name']} {$customer['last_name']} [{$customer['mobile']}] ({$customer['email']})"
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