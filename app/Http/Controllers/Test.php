<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Uxmal\Form;

class Test extends Controller
{
    //
    public function test() {
        return view('workshop.test.root')->extends('workspace.test');
    }
}
