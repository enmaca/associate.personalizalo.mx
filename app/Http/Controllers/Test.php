<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;

class Test extends Controller
{
    //
    public function test()
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $row = $uxmal->component('ui.row', ['options' => ['row.append-attributes' => ['class' => 'flatpickr']]]);

        $row->addElement(\Enmaca\LaravelUxmal\Components\Form\Button::Options([
            'button.type' => 'with-label',
            'button.style' => 'danger',
            'button.name' => 'orderDeliveryDate',
            'button.label' => 'Agregar Fecha de Entrega',
            'button.remix-icon' => 'calendar-event-line'
        ]));
        $row->addElement(\Enmaca\LaravelUxmal\Components\Form\Input\Flatpickr::Options([
            'input.type' => 'flatpickr',
            'flatpickr.label' => null,
            'flatpickr.name' => 'selectDate',
            'flatpickr.append-attributes' => [ 'style' => 'display: none'],
            'flatpickr.date-format' => "d M, Y",
            'flatpickr.positionElement' => '#orderDeliveryDateId'
        ]));
       // $uxmal->componentsInDiv()

        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/test/test.js', 'workshop') . '" type="module"></script>');
        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }

}