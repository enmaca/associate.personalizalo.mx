<?php

namespace App\Http\Controllers;

class ManufacturingController extends Controller
{

    public function dashboard()
    {
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function areas(){
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function products(){
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function laborcosts() {
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function devices(){
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function printvariation(){
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

}
