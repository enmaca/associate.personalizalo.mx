<?php

namespace App\Support\Uxmal\Order;

use Illuminate\Support\Str;

class FormSearchByMobile extends \Enmaca\LaravelUxmal\Abstract\Form
{
    public function build()
    {

        //dump($this->attributes['values']);
        $this->Row();

        $this->Input([
            'input.type' => 'text',
            'input.label' => 'Celular',
            'input.name' => 'customerMobile',
            'input.placeholder' => '(+52) XXXXXXXXXX',
            'input.value' => $this->attributes['values'][str::snake('customerMobile')] ?? '',
            'input.required' => true
        ]);


    }
}

