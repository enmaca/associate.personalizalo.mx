<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Enmaca\LaravelUxmal\UxmalComponent;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;

class Test extends Controller
{
    //
    public function test()
    {
        $uxmal = new UxmalComponent();

        dd(\Enmaca\LaravelUxmal\Components\Form\Input::Options([
            'input.type' => 'checkbox',
            'checkbox.label' => 'Datos del Destinatario igual que el cliente?',
            'checkbox.name' => 'recipientDataSameAsCustomer',
            'checkbox.value' => 1,
            'checkbox.checked' => isset($this->attributes['values'][str::snake('recipientDataSameAsCustomer')]) && $this->attributes['values'][str::snake('recipientDataSameAsCustomer')] == 1
        ]));

        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }

}