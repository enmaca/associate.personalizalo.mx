<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    //
    public function root(){
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function mvg(){
        $uxmal = new \Enmaca\LaravelUxmal\UxmalComponent();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function search_tomselect(Request $request): JsonResponse
    {
        $search = json_decode($request->getContent(), true);

        $context = $request->input('context');

        switch ($context) {
            case 'by_name_sku_desc':
            default:
                $searchObj = new \App\Support\UxmalComponents\Material\SelectByNameSkuDesc();
                return $request->json($searchObj->search($search));
        }

    }
}
