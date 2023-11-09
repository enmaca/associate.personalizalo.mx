<?php

namespace App\Http\Controllers;

use App\Support\UxmalComponents\AddressBook\DefaultForm as AddressBookDefaultForm;
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
        $uxmal = new AddressBookDefaultForm(['options' => ['form.id' => 'deliveryData', 'form.action' => '/order/delivery_data']]);

        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }

}