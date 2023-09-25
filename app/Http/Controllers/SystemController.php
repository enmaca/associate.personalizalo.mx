<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function customers(){
        return view('associates.system.customers')->extends('associates.master');
    }

    public function suppliers(){
        return view('associates.system.suppliers')->extends('associates.master');
    }

    public function taxes(){
        return view('associates.system.taxes')->extends('associates.master');
    }

    public function uom(){
        return view('associates.system.uom')->extends('associates.master');
    }

    public function users(){
        return view('associates.system.users')->extends('associates.master');
    }

    public function products(){
        return view('associates.system.products')->extends('associates.master');
    }
}
