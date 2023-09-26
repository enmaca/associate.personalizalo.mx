<?php

namespace App\Http\Controllers;

use App\Models\OrderProductDetail;
use Illuminate\Http\Request;

class ManufacturingController extends Controller
{

    public function dashboard()
    {
        return view('workshop.manufacturing.dashboard')->extends('workshop.master');
    }

    public function areas(){
        return view('workshop.manufacturing.areas')->extends('workshop.master');
    }

    public function products(){
        return view('workshop.manufacturing.products')->extends('workshop.master');
    }

    public function laborcosts() {
        return view('workshop.manufacturing.laborcosts')->extends('workshop.master');
    }

    public function devices(){
        return view('workshop.manufacturing.devices')->extends('workshop.master');
    }

    public function printvariation(){
        return view('workshop.manufacturing.printvariation')->extends('workshop.master');
    }

}
