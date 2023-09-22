<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function root()
    {
        return view('associates.client.root')->extends('associates.master');
    }
}
