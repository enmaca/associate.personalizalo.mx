<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use App\Models\Customer;
use App\Models\LaborCost;
use App\Models\MfgArea;
use App\Models\MfgOverhead;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderProductDetail;
use App\Models\Product;
use App\Models\Material;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class OrdersController extends Controller
{
    public function root(Request $request)
    {
        return view('workshop.order.root')->extends('workshop.master');
    }

    public function edit(Request $request, $hashed_id){
        $order_id = Hashids::decode($hashed_id);
        $order_data = Order::with(['details', 'customer', 'payments', 'address'])->findOrFail($order_id);
        dd($order_data->toArray());

        switch( $order_data->status ){
            case 'created':
        }
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
        $material_options = Material::pluck('name', 'id')->toArray();
        $laborcost_options = LaborCost::pluck('name', 'id')->toArray();
        $mfgoverhead_options = MfgOverhead::pluck('name', 'id')->toArray();
        $mfgareas_options = MfgArea::pluck('name', 'id')->toArray();

        return view('workshop.order.create', [
            'customer_id' => Hashids::encode($client->id),
            'customer_name' => $client->name,
            'customer_last_name' => $client->last_name,
            'customer_mobile' => $client->mobile,
            'customer_email' => $client->email,
            'order_id' => Hashids::encode($order_data->id),
            'order_code' => $order_data->code,
            'product_options' => $products_options,
            'material_options' => $material_options,
            'laborcost_options' => $laborcost_options,
            'mfgoverhead_options' => $mfgoverhead_options,
            'mfgareas_options' => $mfgareas_options
        ])->extends('workshop.master');
    }
}
