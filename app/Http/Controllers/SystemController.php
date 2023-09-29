<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{
    public function customers(){
        return view('workshop.system.customers')->extends('workshop.master');
    }

    public function suppliers(){
        return view('workshop.system.suppliers')->extends('workshop.master');
    }

    public function taxes(){
        return view('workshop.system.taxes')->extends('workshop.master');
    }

    public function uom(){
        return view('workshop.system.uom')->extends('workshop.master');
    }

    public function users(){
        return view('workshop.system.users')->extends('workshop.master');
    }

    public function products(){
        return view('workshop.system.products')->extends('workshop.master');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
