<?php

namespace App\Http\Controllers;

use App\Support\Enums\ShipmentStatusEnum;
use App\Models\AddressBook;
use App\Models\Customer;
use App\Models\DigitalArt;
use App\Models\DigitalArtCategory;
use App\Models\LaborCost;
use App\Models\MaterialVariationsGroup;
use App\Models\Media;
use App\Models\MexDistricts;
use App\Models\MexMunicipalities;
use App\Models\MexState;
use App\Models\MfgArea;
use App\Models\MfgDevice;
use App\Models\MfgOverhead;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderProductDetail;
use App\Models\OrderProductDynamic;
use App\Models\OrderProductDynamicDetails;
use App\Models\PaymentDetails;
use App\Models\PaymentMethod;
use App\Models\PrintVariationsGroup;
use App\Models\PrintVariationsGroupDetails;
use App\Models\Product;
use App\Models\Material;
use App\Support\Services\OrderService;
use App\Support\Workshop\Order\EditScreen;
use App\Support\Workshop\OrderProductDynamicDetails\SelectDynamicProducts;
use Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException;
use Enmaca\LaravelUxmal\Support\Helpers\UploadS3Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    public function root(Request $request)
    {

        $root_screen = \App\Support\Workshop\Order\Dashboard::Object();

        //$main_row = $uxmal->component('ui.row', []);

        /**
         * Create Predefined Modal with context 'createorder'
         */
        $client_modal = \App\Support\Workshop\Customer\ModalSearchByMobile::Object(['context' => 'createorder']);

        /**
         * Create Predefined ListJS with Conext 'orderhome'
         */
        //$order_listjs = \App\Support\Workshop\Order\ListjsOrderHome::Object(['context' => 'orderhome']);

        /**
         * Set the top button to a listjs object from $modalStruct
         */
        //$order_listjs->setTopButtons($client_modal['button']);

        /**
         * Create the main Card of Page with ListJS in the Body
         */

        /*
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
        // $uxmal->addElement($client_modal['modal']);

        /**
         * PushOnce to scripts
         */
        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/workshop.js', 'workshop') . '" type="module"></script>');
        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/orders/root.js', 'workshop') . '" type="module"></script>');
        View::startPush('livewire:initialized', Vite::content('resources/js/orders/root_livewire.js', 'workshop'));

        dump($root_screen->toArray());
        /**
         * Set View
         */
        return view('uxmal::master-default', [
            'uxmal_data' => $root_screen->toArray()
        ])->extends('uxmal::layout.master');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $allInput = $request->all();
        $customer_data = null;
        $order_data = null;


        //TODO logic to handle edition.
        $allInput['orderId'] = 425;
        unset($allInput['customerId']);

        if (isset($allInput['customerId'])) {
            $customer_data = Customer::findByHashId($allInput['customerId']);

            if (empty($customer_data)) {
                $customer_data = new Customer();
                $customer_data->mobile = $allInput['customerMobile'];
                $customer_data->name = $allInput['customerName'];
                $customer_data->last_name = $allInput['customerLastName'];
                $customer_data->email = $allInput['customerEmail'];
                $customer_data->save();
            }
        } else if (isset($allInput['orderId'])) {
            //$order_id = Order::keyFromHashId($allInput['orderId'];
            $order_id = 425;
            $order_data = Order::findOrFail($order_id);
            $customer_data = Customer::findOrFail( $order_data->customer_id);
        }

        if (empty($order_data))
            $order_data = Order::CreateToCustomer($customer_data->id);

        // $payment_methods_array

        $edit_screen = EditScreen::Object(values: [
            'customer_id' => $customer_data->hashId,
            'customer_name' => $customer_data->name,
            'customer_last_name' => $customer_data->last_name,
            'customer_mobile' => $customer_data->mobile,
            'customer_email' => $customer_data->email,
            'order_id' => $order_data->hashId,
            'order_code' => $order_data->code,
            'order_address_book_id' => $order_data->address_book_id
        ]);

        //dump($edit_screen);
        //dd($edit_screen->toArray());
        View::startPush('scss', '<link rel="stylesheet" href="' . asset('enmaca/laravel-uxmal/assets/swiper.css') . '" type="text/css"/>'); //TODO: REVISAR COMO se va a manejar esto, si lo tiene que manejar laravel-uxmal. al renderizar un swiper o como en este caso es manual[livewire]
        View::startPush('scss', '<link rel="stylesheet" href="' . Vite::asset('resources/scss/orders/create.scss', 'workshop') . '" type="text/css"/>');

        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/workshop.js', 'workshop') . '" type="module"></script>');
        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/orders/create.js', 'workshop') . '" type="module"></script>');

        return view('uxmal::master-default', [
            'uxmal_data' => $edit_screen->toArray()
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
     * @throws UnknownHashIdConfigParameterException
     */
    public
    function post_delivery_data(Request $request, string $hash_id = null)
    {
        $allInput = $request->all();
        /**
         * "recipientDataSameAsCustomer" => "1"
         * "recipientName" => null
         * "recipientLastName" => null
         * "recipientMobile" => null
         * "address1" => "Rodi 410"
         * "address2" => null
         * "zipCode" => "66636"
         * "mexDistrict" => null
         * "mexMunicipalities" => "mex_OyRPzQjp4ZM7k"
         * "mexState" => "mex_L8kmREqGAGOX3"
         * "order_id" => "ord_OyRPzQjWKEM7k"
         * "customer_id" => "cus_WJ2v5Z2xQDO9Y"
         */

        if (empty($allInput['mexDistrict']) || empty(MexDistricts::keyFromHashId($allInput['mexDistrict'])))
            return response()->json(['fail' => 'La colonia necesita ser seleccionada']);

        $order_record = Order::with(['address'])->findOrFail(Order::keyFromHashId($allInput['order_id']));
        if (empty($order_record->address)) {
            $address_record = new AddressBook();
        } else {
            $address_record = $order_record->address;
        }

        if (empty($allInput['recipientDataSameAsCustomer'])) {
            $address_record->recipient_name = $allInput['recipientName'];
            $address_record->recipient_last_name = $allInput['recipientLastName'];
            $address_record->recipient_mobile = $allInput['recipientMobile'];
        } else {
            $address_record->recipient_data_same_as_customer = 1;
        }

        $address_record->customer_id = Customer::keyFromHashId($allInput['customer_id']);
        $address_record->address_1 = $allInput['address1'];
        $address_record->address_2 = $allInput['address2'];
        $address_record->zip_code = $allInput['zipCode'];
        $address_record->district_id = MexDistricts::keyFromHashId($allInput['mexDistrict']);
        $address_record->municipality_id = MexMunicipalities::keyFromHashId($allInput['mexMunicipalities']);
        $address_record->state_id = MexState::keyFromHashId($allInput['mexState']);
        $address_record->directions = $allInput['directions'];
        $address_record->save();

        if ($address_record->save()) {
            $order_record->address_book_id = $address_record->id;
            $order_record->shipment_status = 'pending';
            $order_record->save();
            return response()->json(['ok' => 'La direccion de entrega se actualizo correctamente']);
        } else
            return response()->json(['fail' => 'Error al Actualizar la direccion de entrega']);
    }



    public function post_dynamic_detail_row(Request $request, $hashed_id)
    {
        $order_id = Order::keyFromHashId($hashed_id);

        $allInput = $request->all();
        $order_product_dynamic_id = new OrderProductDynamic();
        $order_product_dynamic_id->description = $allInput['orderProductDynamicDetailsDescription'];
        $order_product_dynamic_id->order_id = $order_id;
        $order_product_dynamic_id->created_by = Auth::id();
        $order_product_dynamic_id->save();

        if ($order_product_dynamic_id->hashId)
            return response()->json([
                'ok' => 'El producto dinámico se agregó correctamente',
                'result' => [
                    'id' => $order_product_dynamic_id->hashId,
                    'description' => $order_product_dynamic_id->description
                ]
            ]);
        else return response()->json(['fail' => 'El producto dinámico no se pudo agregar']);

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



    /**
     * @param Request $request
     * @return mixed
     */
    public
    function test(Request $request)
    {
        $allInput = $request->all();
        if (!empty($allInput['customerId'])) {
            $customer_data = Customer::findByHashId($allInput['customerId']);

        }
    }

}
