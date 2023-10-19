<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * @return mixed
     */
    public function root()
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.master');
    }

    public function search_tomselect(Request $request)
    {
        $search = json_decode($request->getContent(), true);

        $context = $request->input('context');

        switch ($context) {
            default:
                $searchObj = new \App\Support\UxmalComponents\Products\SelectByName();
                return $searchObj->search($search);
        }

    }

    public function get_id(Request $request, mixed $customer_id)
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
