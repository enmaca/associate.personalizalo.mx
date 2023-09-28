<?php

namespace App\Livewire\Client\Search;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class Select extends Component
{
    public $name = 'customerId';
    public $id = 'customerId';
    public $label = 'Cliente';
    public $customer_id = 'new';
    public $place_holder_option = [
        'value' => 'new',
        'name' => 'Nuevo Cliente'
        ];
    public $options = [];
    public $data_choices_opts = [
        'data-choices-sorting-false'
    ];

    public $wire = [
            'wire:change="change_customer_id"',
            'wire:model="customer_id"'
        ];

    public function change_customer_id(){

        if( array_key_exists('value', $this->customer_id) )
            $this->customer_id = $this->customer_id['value'];

        if( $this->customer_id == 'new')
            $customer_data = [
                'id' => $this->customer_id,
                'mobile' => '',
                'name' => '',
                'last_name' => '',
                'email' => ''
            ];
        else if ( (int) $this->customer_id == 4294967295 )
            $customer_data = [
                'id' => $this->customer_id,
                'name' => 'Guest',
                'last_name' => 'Guest',
                'mobile' => 'Guest',
                'email' => 'Guest'
            ];
        else {
            $customer_id = Hashids::decode($this->customer_id)[0];
            $customer_data = Customer::findOrFail($customer_id);
            $customer_data = $customer_data->toArray();
        }

        $this->dispatch('change-customer-id', data: $customer_data );
    }

    public function render()
    {
        $this->options = Customer::orderBy('id', 'desc')->get()->mapWithKeys(function ($client){
            return [ Hashids::encode($client->id) => "{$client->name} [{$client->mobile}]"];
        })->toArray();

        return view('uxmal.livewire.form.select_choices');
    }
}
