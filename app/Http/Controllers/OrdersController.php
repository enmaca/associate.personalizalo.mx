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
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Vinkla\Hashids\Facades\Hashids;

class OrdersController extends Controller
{
    public function root(Request $request)
    {

        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $main_row = $uxmal->component('ui.row', [
            'attributes' => [
                'class' => [
                    'row' => true
                ]
            ]
        ]);

        /**
         * Create Predefined Modal with context 'createorder'
         */
        $client_modal = \App\Support\Uxmal\Customer\ModalSearchByMobile::Object(['context' => 'createorder']);

        /**
         * Create Predefined ListJS with Conext 'orderhome'
         */
        $order_listjs = \App\Support\Uxmal\Order\ListjsOrderHome::Object(['context' => 'orderhome']);

        /**
         * Set the top button to a listjs object from $modalStruct
         */
        $order_listjs->setTopButtons($client_modal['button']);

        /**
         * Create the main Card of Page with ListJS in the Body
         */
        $main_row->component('ui.card', [
            'options' => [
                'header' => 'Pedidos Pendientes',
                'body' => $order_listjs->toArray(),
                'footer' => '&nbsp;'
            ]
        ]);

        /**
         * Add Modal Button to Main Uxmal Struct
         */
        $uxmal->addElement($client_modal['modal']);

        /**
         * PushOnce to scripts
         */
        View::startPush('scripts', '<script src="'.Vite::asset('resources/js/orders/root.js', 'workshop').'" type="module"></script>');
        View::startPush('livewire:initialized', Vite::content('resources/js/orders/root_livewire.js', 'workshop'));

        /**
         * Set View
         */
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.master');
    }

    public function edit(Request $request, $hashed_id){
        $order_id = Hashids::decode($hashed_id);
        if( !is_int($order_id[0]))
            Abort(403, '{order_id} Malformed');

        $order_data = Order::with(['details', 'customer', 'payments', 'address'])->findOrFail($order_id[0]);

        $products_options = Product::pluck('name', 'id')->toArray();
        $material_options = Material::pluck('name', 'id')->toArray();
        $laborcost_options = LaborCost::pluck('name', 'id')->toArray();
        $mfgoverhead_options = MfgOverhead::pluck('name', 'id')->toArray();
        $mfgareas_options = MfgArea::pluck('name', 'id')->toArray();
        switch( $order_data->status ){
            case 'created':
                return view('workshop.order.create', [
                    'customer_id' => Hashids::encode($order_data->customer->id),
                    'customer_name' => $order_data->customer->name,
                    'customer_last_name' => $order_data->customer->last_name,
                    'customer_mobile' => $order_data->customer->mobile,
                    'customer_email' => $order_data->customer->email,
                    'order_id' => Hashids::encode($order_data->id),
                    'order_code' => $order_data->code,
                    'product_options' => $products_options,
                    'material_options' => $material_options,
                    'laborcost_options' => $laborcost_options,
                    'mfgoverhead_options' => $mfgoverhead_options,
                    'mfgareas_options' => $mfgareas_options
                ])->extends('uxmal::layout.master');
                break;
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function Dommcreate(Request $request){
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
        ])->extends('uxmal::layout.master');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request){
        $allInput = $request->all();
        dd($allInput);
    }
}
