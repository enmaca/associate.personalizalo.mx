<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class OrdersController extends Controller
{
    public function root(Request $request)
    {
        return view('workshop.order.root')->extends('workshop.master');
    }

    public function create(Request $request){
        $allInput = $request->all();
        if ($allInput['customerId'] != 'new'){
            $clientId = HashIds::decode($allInput['customerId'])[0];
            dd(Customer::findOrFail($clientId)->toArray());
        } else if($allInput['customerId'] == 'new'){
            $client = new Customer();
            $client->mobile = $allInput['customerMobile'];
            $client->name = $allInput['customerName'];
            $client->last_name = $allInput['customerLastName'];
            $client->email = $allInput['customerEmail'];
            $client->save();
        }
        return view('workshop.order.create', [
            'customer_id' => Hashids::encode($client->id),
            'customer_name' => $client->name,
            'customer_last_name' => $client->last_name,
            'customer_mobile' => $client->mobile,
            'customer_email' => $client->email
        ])->extends('workshop.master');
    }
}
