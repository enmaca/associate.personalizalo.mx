<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DigitalArt;
use App\Models\DigitalArtCategory;
use App\Models\MaterialVariationsGroup;
use App\Models\Order;
use App\Models\PaymentDetails;
use App\Models\PaymentMethod;
use App\Models\PrintVariationsGroup;
use App\Models\PrintVariationsGroupDetails;
use App\Models\Product;
use App\Support\Services\OrderService;
use App\Support\Workshop\Order\EditScreen;
use Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    public function get_orders_dashboard(Request $request): \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Contracts\View\View|Application
    {

        $uxmal = \App\Support\Workshop\Order\Dashboard::Object();


        $uxmal->addScript(Vite::asset('resources/js/orders/dashboard.js', 'workshop'));
        $uxmal->addStyle(asset('workshop/css/uxmal.css'));
        $uxmal->addStyle(asset('workshop/css/icons/remixicon.css'));

        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.master');
    }

    /**
     * @param Request $request
     * @param $order_hashid
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Contracts\View\View|Application
     * @throws UnknownHashIdConfigParameterException
     */
    public function get_orders(Request $request, $order_hashid)
    {
        $order_id = Order::keyFromHashId($order_hashid);
        $order_data = Order::with(['customer', 'address'])->findOrFail($order_id);
        $customer_data = Customer::findOrFail( $order_data->customer_id);

        $uxmal = EditScreen::Object(  values: [
            'customer_id' => $customer_data->hashId,
            'customer_name' => $customer_data->name,
            'customer_last_name' => $customer_data->last_name,
            'customer_mobile' => $customer_data->mobile,
            'customer_email' => $customer_data->email,
            'order_id' => $order_data->hashId,
            'order_code' => $order_data->code,
            'order_address_book_id' => $order_data->address_book_id
        ]);

        $uxmal->addStyle(asset('workshop/css/uxmal.css'));
        $uxmal->addStyle(asset('workshop/css/icons/remixicon.css'));
        $uxmal->addStyle(asset('workshop/css/icons/bootstrap-icons.css'));
        $uxmal->addScript(Vite::asset('resources/scss/orders/create.scss', 'workshop'));

        $uxmal->addScript(Vite::asset('resources/js/workshop.js', 'workshop'));
        $uxmal->addScript(Vite::asset('resources/js/orders/create.js', 'workshop'));

        return view('uxmal::master-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.master');
    }




    /**
     * @param Request $request
     * @return JsonResponse
     *
     * POST Payload
     *      "_token" => "Ss6Muw7QVC0mk7NqASK5ZXFvsgcx0I8ZZ7fJvajv"
     *      "da_category_id_dig_eDwyqQVjQG7xj" => "dig_WJ2v5Z2wJADO9"
     *      "pvg_id_pri_4WmvDA86E98xo" => "pri_rkWV6Z98EvPX3"
     *      "mvg_color_mat_B95oKZdvQJMPv" => "643633"
     *      "mvg_size_mat_B95oKZdvQJMPv" => "M"
     *      "order_id" => "ord_eV7yYZn5OEWvX"
     *      "customer_id" => "cus_WJ2v5Z2xQDO9Y"
     */
    public
    function post_product(Request $request)
    {
        $allInput = $request->all();
        $digital_art_category_id = null;
        $print_variation_group_id = null;
        $mvg_id = null;
        $mvg_selected_color = null;
        $mvg_selected_size = null;
        $print_variation_group_detail_id = null;
        $catalog_product_id = null;
        $digital_art_id = null;
        $order_id = null;
        $customer_id = null;
        $quantity = null;
        foreach ($allInput as $field_key => $field_value) {
            if (Str::startsWith($field_key, 'da_category_id_')) {
                $digital_art_category_id = DigitalArtCategory::keyFromHashId(str_replace('da_category_id_', '', $field_key));
                $digital_art_id = DigitalArt::keyFromHashId($field_value);
            } else if (Str::startsWith($field_key, 'pvg_id_')) {
                $print_variation_group_id = PrintVariationsGroup::keyFromHashId(str_replace('pvg_id_', '', $field_key));
                $print_variation_group_detail_id = PrintVariationsGroupDetails::keyFromHashId($field_value);
            } else if (Str::startsWith($field_key, 'mvg_color_')) {
                $mvg_id = MaterialVariationsGroup::keyFromHashId(str_replace('mvg_color_', '', $field_key));
                $mvg_selected_color = $field_value;
            } else if (Str::startsWith($field_key, 'mvg_size_')) {
                $mvg_id = MaterialVariationsGroup::keyFromHashId(str_replace('mvg_size_', '', $field_key));
                $mvg_selected_size = $field_value;
            } else if ($field_key === 'order_id') {
                $order_id = Order::keyFromHashId($field_value);
            } else if ($field_key === 'customer_id') {
                $customer_id = Customer::keyFromHashId($field_value);
            } else if ($field_key === 'catalog_product_id') {
                $catalog_product_id = Product::keyFromHashId($field_value);
            } else if ($field_key === 'quantity') {
                $quantity = $field_value;
            }
        }


        try {
            $result = OrderService::addProductWithDigitalArt([
                'mvg_id' => $mvg_id,
                'mvg_selected_color' => $mvg_selected_color,
                'mvg_selected_size' => $mvg_selected_size,
                'print_variation_group_id' => $print_variation_group_id,
                'print_variation_group_detail_id' => $print_variation_group_detail_id,
                'digital_art_category_id' => $digital_art_category_id,
                'digital_art_id' => $digital_art_id,
                'order_id' => $order_id,
                'customer_id' => $customer_id,
                'catalog_product_id' => $catalog_product_id,
                'quantity' => $quantity
            ]);
            OrderService::updateCostPrices($order_id);
        } catch (\Exception $e) {
            return response()->json(['fail' => $e->getMessage()]);
        }

        return response()->json(['ok' => $result]);
    }


    /**
     * @throws UnknownHashIdConfigParameterException
     */
    public
    function put_payment(Request $request)
    {
        $allInput = $request->all();

        if (empty($allInput['paymentMethod']))
            return response()->json(['fail' => 'Se necesita seleccionar el methodo de pago.']);

        $payment_method_id = PaymentMethod::keyFromHashId($allInput['paymentMethod']);

        $PaymentDetails = new PaymentDetails();
        $PaymentDetails->payment_method_id = $payment_method_id;
        $PaymentDetails->customer_id = Customer::keyFromHashId($allInput['customer_id']);
        $PaymentDetails->order_id = Order::keyFromHashId($allInput['order_id']);
        $PaymentDetails->amount = $allInput['amount'];
        $PaymentDetails->created_by = Auth::id();
        $PaymentDetails->save();

        if (OrderService::updateCostPrices($PaymentDetails->order_id)) {
            return response()->json(['ok' => 'Se ingreso el pago correctamente.']);
        } else
            return response()->json(['fail' => 'Error al ingresar el pago.']);
    }

}
