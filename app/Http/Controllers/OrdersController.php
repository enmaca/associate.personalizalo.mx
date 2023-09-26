<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function root()
    {
        return view('workshop.order.root')->extends('workshop.master');
    }
}
