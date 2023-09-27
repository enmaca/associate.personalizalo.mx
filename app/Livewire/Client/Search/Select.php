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
    public $data_choices_opts = [];

    public $wire = [
            'wire:change="change_customer_id"',
            'wire:model="customer_id"'
        ];

    public function change_customer_id(){
        if( $this->customer_id == 'new')
            $customer_data = [
                'id' => $this->customer_id,
                'mobile' => '',
                'name' => '',
                'last_name' => '',
                'email' => ''
            ];
        else if ( $this->customer_id == 'guest' )
            $customer_data = [
                'id' => $this->customer_id,
                'name' => 'Guest',
                'last_name' => 'Guest',
                'mobile' => 'Guest',
                'email' => 'Guest'
            ];
        else {
            if( is_array($this->customer_id) && array_key_exists('value', $this->customer_id))
                $this->customer_id = $this->customer_id['value'];

            $customer_id = Hashids::decode($this->customer_id)[0];
            $customer_data = Customer::findOrFail($customer_id);
            $customer_data = $customer_data->toArray();
        }

        $customer_data['select_id_old'] = $this->id;
        $this->id = 'customerId'.bin2hex(random_bytes(3));
        $customer_data['select_id_new'] = $this->id;

        $this->dispatch('change-customer-id', data: $customer_data );
    }

    public function render()
    {
        $this->options = Customer::all()->mapWithKeys(function ($client){
            return [ Hashids::encode($client->id) => "{$client->name} [{$client->mobile}]"];
        })->toArray();
        return view('uxmal.livewire.form.select_choices');
    }
}
