<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    //
    public function root(){
        return view('workshop.materials.root')->extends('workshop.master');
    }

    public function mvg(){
        return view('workshop.materials.materialvariation')->extends('workshop.master');
    }

    public function search_tomselect(Request $request)
    {
        $search = json_decode($request->getContent(), true);

        $context = $request->input('context');

        switch ($context) {
            case 'by_name_sku_desc':
            default:
                $searchObj = new \App\Support\UxmalComponents\Material\SelectByNameSkuDesc();
                return $searchObj->search($search);
        }

    }
}
