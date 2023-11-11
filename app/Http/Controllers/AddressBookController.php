<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressBookController extends Controller
{
    public function search_tomselect_mex_district(Request $request)
    {
        $search = json_decode($request->getContent(), true);

        $context = $request->input('context');

        switch ($context) {
            default:
                $searchObj = new \App\Support\Workshop\AddressBook\SelectMexDistricts();
                if (str_starts_with($search, 'zipcode::')) {
                    $search = str_replace('zipcode::', '', $search);
                    return $searchObj->searchByPostalCode($search);
                } else
                    return $searchObj->search($search);

        }
    }

    public function search_tomselect_mex_municipality(Request $request)
    {
        $search = json_decode($request->getContent(), true);

        $context = $request->input('context');

        switch ($context) {
            default:
                $searchObj = new \App\Support\Workshop\AddressBook\SelectMexMunicipalities();
                if (str_starts_with($search, 'zipcode::')) {
                    $search = str_replace('zipcode::', '', $search);
                    return $searchObj->searchByPostalCode($search);
                } else
                    return $searchObj->search($search);

        }
    }

    public function search_tomselect_mex_state(Request $request)
    {
        $search = json_decode($request->getContent(), true);

        $context = $request->input('context');

        switch ($context) {
            default:
                $searchObj = new \App\Support\Workshop\AddressBook\SelectMexStates();
                if (str_starts_with($search, 'zipcode::')) {
                    $search = str_replace('zipcode::', '', $search);
                    return $searchObj->searchByPostalCode($search);
                } else
                    return $searchObj->search($search);

        }
    }
}
