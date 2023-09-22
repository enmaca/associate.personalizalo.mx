<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function root()
    {
        return view('associates.order.root')->extends('associates.master');
    }
}
