<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Test extends Controller
{
    //
    public function test() {
        return view('workshop.test.root')->extends('workspace.test');
    }
}
