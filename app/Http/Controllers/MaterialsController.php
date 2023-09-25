<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    //
    public function root(){
        return view('associates.materials.root')->extends('associates.master');
    }

    public function materialvariation(){
        return view('associates.materials.materialvariation')->extends('associates.master');
    }
}
