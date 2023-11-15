<?php

namespace App\Http\Controllers;

use App\Models\MfgOverhead;
use App\Support\Services\OrderService;
use Enmaca\LaravelUxmal\Components\Form\Input\Checkbox;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputCheckboxOptions;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextAreaOptions;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;

class Test extends Controller
{
    //
    public function test()
    {

        /*
        $uxmal = Checkbox::Options(new InputCheckboxOptions(
            name: 'deliveryNeeded',
            label: 'Se recogera en tienda',
            style: 'primary',
            type: 'switch',
            value: '1',
            direction: 'right'
        ));

        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/test/test.js', 'workshop') . '" type="module"></script>');

        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
        */

        //dd($data = MfgOverhead::with('taxes')->findOrFail(1)->toArray());

        OrderService::updateTotal(6);
    }

}