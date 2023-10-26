<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{
    public function customers(){
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function suppliers(){
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function taxes(){
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function uom(){
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $main_row = $uxmal->component('ui.row');
        $listjs = \App\Support\UxmalComponents\System\Uom\ListJsUomHome::Object(['context' => 'uomhome']);

        $main_row->component('ui.card', [
            'options' => [
                'card.header' => 'Listado de Unidades de Medida',
                'card.body' => $listjs->toArray(),
                'card.footer' => '',
            ],
        ]);

        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function users(){
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function products(){
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
