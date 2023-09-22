<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManufacturingController extends Controller
{
    //
    public function dashboard()
    {
        return view('associates.manufacturing.dashboard')->extends('associates.master');
    }

    public function products(){
        return view('associates.manufacturing.products')->extends('associates.master');
    }
}
