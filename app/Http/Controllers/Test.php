<?php

namespace App\Http\Controllers;

use App\Support\Workshop\Order\EditScreen\MainContent\ClientCard;
use Enmaca\LaravelUxmal\Support\Options\Ui\CardOptions;
use Exception;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;

class Test extends Controller
{
    //

    /**
     * @throws Exception
     */
    public function test()
    {


        $dd = new CardOptions(
            name: 'clientCard',
            header: 'Datos Cliente/Entrega',
            headerRight: 'right',
            style: 'primary'
        );

        $uxmal = ClientCard::Object(
            values: [],
            options: $dd->toArray());


        //dd(CardOptions::Make()->name('clientCard')->header('Datos Cliente/Entrega')->headerRight('Hola')->body(null)->footer(null)->style('primary'));
        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/test/test.js', 'workshop') . '" type="module"></script>');


        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }

}