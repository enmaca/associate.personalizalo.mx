<?php

namespace App\Support\Uxmal\Order;

use Enmaca\LaravelUxmal\Abstract\FormBlock;
use Illuminate\Support\Str;

class FormSearchByMobile extends FormBlock
{
    /**
     * @throws \Exception
     */
    public function build(): void
    {
        $this->ContentAddRow();

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

