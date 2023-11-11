<?php

namespace App\Http\Controllers;

use Enmaca\LaravelUxmal\Components\Form\Input\TextArea;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputTextAreaOptions;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;

class Test extends Controller
{
    //
    public function test()
    {

        $uxmal = TextArea::Options(new InputTextAreaOptions(
                label: 'Indicaciones de Entrega',
                name: 'directions',
                value: 'texto de prueba',
                rows: 3
            ));

        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/test/test.js', 'workshop') . '" type="module"></script>');

        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }

}