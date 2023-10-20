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

        $main_row = $uxmal->component('ui.row', []);

        /**
         * Create Predefined Modal with context 'createorder'
         */
        $client_modal = \App\Support\UxmalComponents\Customer\ModalSearchByMobile::Object(['context' => 'createorder']);

        /**
         * Create Predefined ListJS with Conext 'orderhome'
         */
        $order_listjs = \App\Support\UxmalComponents\Order\ListjsOrderHome::Object(['context' => 'orderhome']);

        /**
         * Set the top button to a listjs object from $modalStruct
         */
        $order_listjs->setTopButtons($client_modal['button']);

        /**
         * Create the main Card of Page with ListJS in the Body
         */
        $main_row->component('ui.card', [
            'options' => [
                'card.header' => 'Pedidos Pendientes',
                'card.body' => $order_listjs->toArray(),
                'card.footer' => '&nbsp;'
            ]
        ]);

        /**
         * Add Modal Button to Main Uxmal Struct
         */
        $uxmal->addElement($client_modal['modal']);

        /**
         * PushOnce to scripts
         */
        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/orders/root.js', 'workshop') . '" type="module"></script>');
        View::startPush('livewire:initialized', Vite::content('resources/js/orders/root_livewire.js', 'workshop'));

        /**
         * Set View
         */
        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.master');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $allInput = $request->all();
        $customer_data = null;
        $order_data = null;

        if (isset($allInput['customerId'])) {
            $customer_data = Customer::findByHashId($allInput['customerId']);

            if (!isset($allInput['customerId']) || empty($customer_data)) {
                $customer_data = new Customer();
                $customer_data->mobile = $allInput['customerMobile'];
                $customer_data->name = $allInput['customerName'];
                $customer_data->last_name = $allInput['customerLastName'];
                $customer_data->email = $allInput['customerEmail'];
                $customer_data->save();
            }
        } else if (isset($allInput['orderId'])) {
            //TODO: Get OrderData
        }

        if (empty($order_data))
            $order_data = Order::CreateToCustomer($customer_data->id);


        $products_options = Product::select('name', 'id');
        $material_options = Material::pluck('name', 'id');
        $laborcost_options = LaborCost::pluck('name', 'id');
        $mfgoverhead_options = MfgOverhead::pluck('name', 'id');
        $mfgareas_options = MfgArea::pluck('name', 'id');

        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $main_row = $uxmal->component('ui.row', [
            'attributes' => [
                'class' => [
                    'row gy-4' => true
                ]
            ]
        ]);

        $form = \App\Support\UxmalComponents\Order\FormCreateEdit::Object([
            'options' => [
                'form.id' => 'customerData',
                'form.action' => '/customer',
                'form.method' => 'PUT'
            ],
            'values' => [
                'customer_id' => $customer_data->hashId,
                'customer_name' => $customer_data->name,
                'customer_last_name' => $customer_data->last_name,
                'customer_mobile' => $customer_data->mobile,
                'customer_email' => $customer_data->email,
                'order_id' => $order_data->hashed_id,
                'order_code' => $order_data->code
            ]]);

        $main_row->component('ui.card', [
            'options' => [
                'card.header' => 'Pedido '. $order_data->code,
                'card.body' => $form->toArray(),
                'card.footer' => '&nbsp;'
            ]
        ]);

        $modal = \App\Support\UxmalComponents\Products\ModalSelectProductWithDigitalArt::Object();


        $main_row->addElement($modal['modal']);

        /*
                dump(
                    'product_options' => $products_options,
                    'material_options' => $material_options,
                    'laborcost_options' => $laborcost_options,
                    'mfgoverhead_options' => $mfgoverhead_options,
                    'mfgareas_options' => $mfgareas_options]);

                */

        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/orders/create.js', 'workshop') . '" type="module"></script>');

        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()

        ])->extends('uxmal::layout.master');
    }

    public function edit(Request $request, $hashed_id)
    {
        $order_id = Hashids::decode($hashed_id);
        if (!is_int($order_id[0]))
            Abort(403, '{order_id} Malformed');

        $order_data = Order::with(['details', 'customer', 'payments', 'address'])->findOrFail($order_id[0]);

        $products_options = Product::pluck('name', 'id')->toArray();
        $material_options = Material::pluck('name', 'id')->toArray();
        $laborcost_options = LaborCost::pluck('name', 'id')->toArray();
        $mfgoverhead_options = MfgOverhead::pluck('name', 'id')->toArray();
        $mfgareas_options = MfgArea::pluck('name', 'id')->toArray();
        switch ($order_data->status) {
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
    public function test(Request $request)
    {
        $allInput = $request->all();
        if (!empty($allInput['customerId'])) {
            $customer_data = Customer::findByHashId($allInput['customerId']);

        }
    }
}
