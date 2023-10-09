<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * @return mixed
     */
    public function root()
    {
        return view('workshop.client.root')->extends('workshop.master');
    }
}
