<?php

namespace App\Support\Workshop\Customer;

use Enmaca\LaravelUxmal\Abstract\FormBlock;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Illuminate\Support\Str;

class FormSearchByMobile extends FormBlock
{
    /**
     * @throws \Exception
     */
    public function build(): void
    {
        $this->ContentAddRow();

        $this->Input(new InputTextOptions(
            label: 'Celular',
            name: 'customerMobile',
            placeholder: '(+52) XXXXXXXXXX',
            value: $this->attributes['values'][str::snake('customerMobile')] ?? '',
            required: true
        ));
    }
}

