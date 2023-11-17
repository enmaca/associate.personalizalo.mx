<?php

namespace App\Http\Controllers;

use App\Support\Workshop\MfgDevices\SelectByName as MfgDevicesSelectByName;
use Illuminate\Http\Request;

class ManufacturingDevicesController extends Controller
{
    public function search_tomselect(Request $request)
    {
        $search = json_decode($request->getContent(), true);

        $context = $request->input('context');

        switch ($context) {
            default:
                $searchObj = new MfgDevicesSelectByName(['context' => $context]);
                if (str_starts_with($search, 'mfgArea::')) {
                    $search = str_replace('mfgArea::', '', $search);
                    return $searchObj->searchByMfgArea($search);
                } else
                    return $searchObj->search($search);
        }
    }
}