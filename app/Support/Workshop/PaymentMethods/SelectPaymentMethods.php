<?php

namespace App\Support\Workshop\PaymentMethods;

use App\Models\Customer;
use App\Models\PaymentMethod;
use Enmaca\LaravelUxmal\Block\SelectTomSelectBlock;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class SelectPaymentMethods extends SelectTomSelectBlock
{

    /**
     * @return void
     * @throws Exception
     */
    public function build(): void
    {
        $customer_hashId = $this->GetValue('customer_id');
        $customer_id = Customer::keyFromHashId($customer_hashId);
        if ($customer_id) {
            $payment_methods = PaymentMethod::where(function ($query) use ($customer_id) {
                $query->where('account_scope', 'general')
                    ->orWhere(function ($query) use ($customer_id) {
                        $query->where('account_scope', 'customer')
                            ->where('customer_id', $customer_id);
                    });
            })->get();
        } else {
            $payment_methods = PaymentMethod::where('account_scope', 'general')->get();
        }

        $items = [];

        foreach( $payment_methods as $payment_method )
            $items[$payment_method->hashId] = "{$payment_method->name}";

        $this->_content = UxmalComponent::Make('form.select.tomselect', [
            'options' => [
                'tomselect.label' => 'Metodos de Pago',
                'tomselect.name' => 'paymentMethod',
                'tomselect.placeholder' => 'Seleccionar...',
                'tomselect.load-url' => route('payment_method_search_tomselect', [ 'customer_id' => $customer_hashId]),
                'tomselect.options' => $items,
                'tomselect.allow-empty-option' => false,
                'tomselect.require' => true,
            ]
        ]);
    }

    /**
     * @param string $query
     * @return array
     */
    public function search(string $query): array
    {
        $customer_hashId = $this->GetValue('customer_id');
        $customer_id = Customer::keyFromHashId($customer_hashId);
        if ($customer_id) {
            $payment_methods = PaymentMethod::query()
                ->where(function ($query) use ($customer_id) {
                    $query->where('account_scope', 'general')
                        ->orWhere(function ($query) use ($customer_id) {
                            $query->where('account_scope', 'customer')
                                ->where('customer_id', $customer_id);
                        });
                })
                ->where('name', 'like', "%{$query}%")
                ->select([
                    'id',
                    'name'
                ])
                ->get();
        } else {
            $payment_methods = PaymentMethod::query()
                ->where('account_scope', 'general')
                ->where('name', 'like', "%{$query}%")
                ->select([
                    'id',
                    'name'
                ])
                ->get();
        }

        $items = [];

        foreach ( $payment_methods as $payment_method ){
            $items[] = [
                'value' => $payment_method->hashId,
                'label' => $payment_method->name
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