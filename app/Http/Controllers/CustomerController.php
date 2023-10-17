<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @return mixed
     */
    public function root()
    {
        return view('workshop.client.root')->extends('workshop.master');
    }

    public function search_tomselect(Request $request)
    {
        $search = json_decode($request->getContent(), true);

        $context = $request->input('context');

        switch ($context) {
            case 'by_name_mobile_email':
            default:
                $searchObj = new \App\Support\Uxmal\Customer\SelectByNameMobileEmail();
                return $searchObj->search($search);
        }

    }

    public function get_id(Request $request, int $customer_id)
    {
        $context = $request->input('context');

        switch ($context) {
            case 'by_name_mobile_email':
            default:
                $client = Customer::findOrFail($customer_id);
                return response()->json($client);
        }

    }
}
