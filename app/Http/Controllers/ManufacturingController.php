<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManufacturingController extends Controller
{

    public function dashboard()
    {
        return view('associates.manufacturing.dashboard')->extends('associates.master');
    }

    public function areas(){
        return view('associates.manufacturing.areas')->extends('associates.master');
    }

    public function products(){
        return view('associates.manufacturing.products')->extends('associates.master');
    }

    public function laborcosts() {
        return view('associates.manufacturing.laborcosts')->extends('associates.master');
    }

    public function devices(){
        return view('associates.manufacturing.devices')->extends('associates.master');
    }

    public function printvariation(){
        return view('associates.manufacturing.printvariation')->extends('associates.master');
    }

}
