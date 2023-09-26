<?php

namespace App\Livewire\Client\Search;

use App\Models\Customer;
use Livewire\Component;


class Select extends Component
{
    public $name = 'customer.id';
    public $id = 'customer.id';
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
        $this->dispatch('change-customer-id', data: ['id' => $this->customer_id]);
    }

    public function render()
    {
        $this->options = Customer::all()->mapWithKeys(function ($client){
            return [ $client->id => "{$client->name} [{$client->mobile}]"];
        })->toArray();
        return view('uxmal.livewire.form.select_choices');
    }
}
