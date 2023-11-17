<?php

namespace App\Http\Controllers;

use App\Support\Workshop\MfgArea\SelectByName as MfgAreaSelectByName;
use Illuminate\Http\Request;

class ManufacturingAreasController extends Controller
{
    public function search_tomselect(Request $request)
    {
        $search = json_decode($request->getContent(), true);

        $context = $request->input('context');

        switch ($context) {
            default:
                $searchObj = new MfgAreaSelectByName(['context' => $context]);
                return $searchObj->search($search);
        }
    }
}