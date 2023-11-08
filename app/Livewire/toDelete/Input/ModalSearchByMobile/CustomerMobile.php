<?php

namespace App\Livewire\toDelete\Input\ModalSearchByMobile;

use App\Models\Customer;
use Livewire\Component;

class CustomerMobile extends Component
{
    public $customer_mobile = "";

    protected $rules = [];

    public function mount()
    {

    }

    public function updating($property, $value)
    {
        // $property: The name of the current property being updated
        // $value: The value about to be set to the property

        switch ($property) {
            case 'customer_mobile':
                $this->__UpdateCustomerMobile($value);
                break;

        }
    }



    public function render()
    {
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
        $input = $uxmal->component('form.input', [
            'options' => [
                'type' => 'text',
                'label' => 'Celular',
                'input.name' => 'customerMobile',
                'input.placeholder' => '(+52) XXXXXXXXXX',
                'input.required' => true,
                'input.append-attributes' => [
                    'wire:model.live' => 'customer_mobile'
                ]
            ]
        ]);

        return view('uxmal::livewire', ['data' => $uxmal->toArray()]);
    }

    private function __UpdateCustomerMobile($value) {
        if( strlen($value) == 10 ){
            $customer = Customer::where('mobile',  '+52'.$value)->first();
            if(!empty($customer)){
                $customer_array = $customer->toArray();
                $this->customer_mobile = $customer_array['mobile'];
                $this->dispatch('customer-id-find', data: $customer_array);
            }

        }



    }
}
