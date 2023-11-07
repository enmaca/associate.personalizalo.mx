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
        $uxmal = new \App\Support\UxmalComponents\AddressBook\DefaultForm(['options' => ['form.id' => 'deliveryData', 'form.action' => '/order/delivery_data']]);

        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/test/test.js', 'workshop') . '" type="module"></script>');
        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }

}