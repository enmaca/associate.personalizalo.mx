<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    //
    public function root(){
        return view('workshop.materials.root')->extends('workshop.master');
    }

    public function materialvariation(){
        return view('workshop.materials.materialvariation')->extends('workshop.master');
    }
}
