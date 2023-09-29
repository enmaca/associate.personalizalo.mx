<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class OrdersController extends Controller
{
    public function root(Request $request)
    {
        return view('workshop.order.root')->extends('workshop.master');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request){
        $allInput = $request->all();
        if ($allInput['customerId'] != 'new'){
            $clientId = HashIds::decode($allInput['customerId'])[0];
            $client = Customer::findOrFail($clientId);
        } else if($allInput['customerId'] == 'new'){
            $client = new Customer();
            $client->mobile = $allInput['customerMobile'];
            $client->name = $allInput['customerName'];
            $client->last_name = $allInput['customerLastName'];
            $client->email = $allInput['customerEmail'];
            $client->save();
        }

        $order_data = new Order();
        $order_data->customer_id = $client->id;
        // Generate Random Order Code
        $order_date_part = date('Ym');
        $order_six_digit_hex = bin2hex(random_bytes(3));  // 3 bytes = 6 hex digits
        // Combine the parts with hyphens
        $order_data->code = strtoupper("{$order_date_part}-{$order_six_digit_hex}");
        $order_data->save();

        $products_options = Product::pluck('name', 'id')->toArray();
        $material_options = Materials::pluck('name', 'id')->toArray();

        return view('workshop.order.create', [
            'customer_id' => Hashids::encode($client->id),
            'customer_name' => $client->name,
            'customer_last_name' => $client->last_name,
            'customer_mobile' => $client->mobile,
            'customer_email' => $client->email,
            'order_id' => Hashids::encode($order_data->id),
            'order_code' => $order_data->code,
            'product_options' => $products_options
        ])->extends('workshop.master');
    }
}
