<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @return mixed
     */
    public function root(Request $request)
    {
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
            case 'by_name_mobile_email':
            default:
                $searchObj = new \App\Support\UxmalComponents\Customer\SelectByNameMobileEmail();
                return response()->json($searchObj->search($search));
        }

    }

    public function get_id(Request $request, mixed $customer_id): JsonResponse
    {
        $context = $request->input('context');

        switch ($context) {
            case 'by_name_mobile_email':
            default:
                $client = Customer::findByHashId($customer_id);
                return response()->json($client);
        }

    }
}
