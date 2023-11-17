<?php

namespace App\Http\Controllers;

use App\Models\MfgOverhead;
use App\Support\Services\OrderService;
use Enmaca\LaravelUxmal\Components\Form\Input;
use Enmaca\LaravelUxmal\Components\Form\Input\Checkbox;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputCheckboxOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextAreaOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextOptions;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;

class Test extends Controller
{
    //
    public function test()
    {

        $AdvancePaymentCheckbox = Input::Options(new InputCheckboxOptions(
            name: 'advance_payment_50',
            label: 'Anticipo (50%)',
            type: 'switch',
            direction: 'right',
            checked: false,
            disabled: false,
        ))->toHtml();

        $uxmal = Input::Options(new InputTextOptions(
            label: '<div class="d-flex" style="align-content: center"><div class="col-6">Monto </div><div class="col-6">' . $AdvancePaymentCheckbox . '</div></div>',
            name: 'amount',
            placeholder: 'Monto',
            required: true,
            labelAppendAttributes: ['style' => ['width: 100%']],
            readonly: true
        ));

        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/test/test.js', 'workshop') . '" type="module"></script>');

        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');

    }

}