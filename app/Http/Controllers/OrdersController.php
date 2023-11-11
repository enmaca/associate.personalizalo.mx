<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use App\Models\Customer;
use App\Models\DigitalArt;
use App\Models\DigitalArtCategory;
use App\Models\LaborCost;
use App\Models\MaterialVariationsGroup;
use App\Models\MexDistricts;
use App\Models\MexMunicipalities;
use App\Models\MexState;
use App\Models\MfgArea;
use App\Models\MfgOverhead;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderProductDetail;
use App\Models\OrderProductDynamic;
use App\Models\OrderProductDynamicDetails;
use App\Models\PrintVariationsGroup;
use App\Models\PrintVariationsGroupDetails;
use App\Models\Product;
use App\Models\Material;
use App\Support\Services\OrderService;
use Carbon\Carbon;
use Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


        $edit_screen = \App\Support\Workshop\Order\EditScreen::Object(values: [
            'customer_id' => $customer_data->hashId,
            'customer_name' => $customer_data->name,
            'customer_last_name' => $customer_data->last_name,
            'customer_mobile' => $customer_data->mobile,
            'customer_email' => $customer_data->email,
            'order_id' => $order_data->hashId,
            'order_code' => $order_data->code
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
     * @param Request $request
     *      [laborCostId] => lab_XXXXXX
     *      [laborCostQuantity] => 15
     *      [laborCostSubtotal] => $18.13
     *      [order_id] => ord_XXXXX
     *      [customer_id] => cus_XXXXX
     * @return void
     */
    public function post_labor_cost(Request $request)
    {
        $allInput = $request->all();

        if (!empty($allInput['laborCostId']))
            $catalog_labor_cost_id = LaborCost::keyFromHashId($allInput['laborCostId']);

        if (!empty($allInput['order_id']))
            $order_id = Order::keyFromHashId($allInput['order_id']);

        if (!empty($allInput['customer_id']))
            $customer_id = Customer::keyFromHashId($allInput['customer_id']);

        if (!empty($catalog_labor_cost_id) && !empty($order_id) && !empty($customer_id)) {
            $labor_cost_data = LaborCost::with('taxes')->findOrFail($catalog_labor_cost_id);
            $labor_costs = $labor_cost_data->calculateCosts($allInput['laborCostQuantity']);
            /**
             * $labor_costs
             * 'uom' => $costByMinute,
             * 'cost' => $cost,
             * 'taxes' => $taxes,
             * 'profit_margin' => 0,
             * 'subtotal' => ($cost + $taxes)
             */
            $OrderProductDynamicData = OrderProductDynamic::where('order_id', $order_id)->first();

            if (empty($OrderProductDynamicData)) {
                $OrderProductDynamicData = new OrderProductDynamic();
                $OrderProductDynamicData->order_id = $order_id;
                $OrderProductDynamicData->save();
            }
            $OrderProductDynamicDataDetail = new OrderProductDynamicDetails();

            $OrderProductDynamicDataDetail->order_product_dynamic_id = $OrderProductDynamicData->id;
            $OrderProductDynamicDataDetail->reference_type = 'catalog_labor_costs';
            $OrderProductDynamicDataDetail->reference_id = $catalog_labor_cost_id;
            $OrderProductDynamicDataDetail->quantity = $allInput['laborCostQuantity'];
            $OrderProductDynamicDataDetail->cost = $labor_costs['cost'];
            $OrderProductDynamicDataDetail->taxes = $labor_costs['taxes'];
            $OrderProductDynamicDataDetail->profit_margin = $labor_costs['profit_margin'];
            $OrderProductDynamicDataDetail->subtotal = $labor_costs['subtotal'];
            $OrderProductDynamicDataDetail->created_by = Auth::id();

            $OrderProductDynamicDataDetail->save();
            return response()->json(['ok' => $OrderProductDynamicDataDetail->hashId]);
        }
        return response()->json(['fail' => 'Error']);
    }

    /**
     * @param Request $request
     * @param string $opdd_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException
     *
     * http://127.0.0.1:8000/orders/dynamic_detail/ord_4WmvDA86E98xo
     */
    public function delete_dynamic_detail_row(Request $request, string $opdd_id)
    {
        $order_product_dynamic_id = OrderProductDynamicDetails::keyFromHashId($opdd_id);
        $order_product_dynamic_row = OrderProductDynamicDetails::find($order_product_dynamic_id);
        if ($order_product_dynamic_row) {
            if ($order_product_dynamic_row->delete())
                return response()->json(['ok' => 'El registro se elimino correctamente']);
            else
                return response()->json(['fail' => 'El registro no se pude eliminar']);
        }
        return response()->json(['warning' => 'El registro no se encontro']);
    }

    /**
     * @param Request $request
     * @param string $opd_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException
     *
     * http://127.0.0.1:8000/orders/dynamic_detail/ord_4WmvDA86E98xo
     */
    public function delete_product_detail_row(Request $request, string $opd_id)
    {
        $order_product_detail_id = OrderProductDetail::keyFromHashId($opd_id);
        $order_product_row = OrderProductDetail::find($order_product_detail_id);
        if ($order_product_row) {
            if ($order_product_row->delete())
                return response()->json(['ok' => 'El registro se elimino correctamente']);
            else
                return response()->json(['fail' => 'El registro no se pude eliminar']);
        }
        return response()->json(['warning' => 'El registro no se encontro']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException
     *
     * "_token" => "hB1ZwcBKBk90zRJXzawKb7xite6Bo5fYOiAXIcas"
     * "mfgOverheadQuantity" => "1"
     * "mfgOverheadSubtotal" => "$1.16"
     * "order_id" => "ord_4WmvDE83DQ98x"
     * "customer_id" => "cus_WJ2v5Z2xQDO9Y"
     * ]
     */
    public function post_mfg_overhead(Request $request)
    {
        $allInput = $request->all();

        if (!empty($allInput['mfgOverheadId']))
            $mfg_overhead_cost_id = MfgOverhead::keyFromHashId($allInput['mfgOverheadId']);

        if (!empty($allInput['order_id']))
            $order_id = Order::keyFromHashId($allInput['order_id']);

        if (!empty($allInput['customer_id']))
            $customer_id = Customer::keyFromHashId($allInput['customer_id']);

        if (!empty($mfg_overhead_cost_id) && !empty($order_id) && !empty($customer_id)) {
            $mfg_overhead_data = MfgOverhead::with('taxes')->findOrFail($mfg_overhead_cost_id);
            $mfg_overhead_costs = $mfg_overhead_data->calculateCosts($allInput['mfgOverheadQuantity']);

            $OrderProductDynamicData = OrderProductDynamic::where('order_id', $order_id)->first();

            if (empty($OrderProductDynamicData)) {
                $OrderProductDynamicData = new OrderProductDynamic();
                $OrderProductDynamicData->order_id = $order_id;
                $OrderProductDynamicData->save();
            }
            $OrderProductDynamicDataDetail = new OrderProductDynamicDetails();

            $OrderProductDynamicDataDetail->order_product_dynamic_id = $OrderProductDynamicData->id;
            $OrderProductDynamicDataDetail->reference_type = 'mfg_overhead';
            $OrderProductDynamicDataDetail->reference_id = $mfg_overhead_cost_id;
            $OrderProductDynamicDataDetail->quantity = $allInput['mfgOverheadQuantity'];
            $OrderProductDynamicDataDetail->cost = $mfg_overhead_costs['cost'];
            $OrderProductDynamicDataDetail->taxes = $mfg_overhead_costs['taxes'];
            $OrderProductDynamicDataDetail->profit_margin = $mfg_overhead_costs['profit_margin'];
            $OrderProductDynamicDataDetail->subtotal = $mfg_overhead_costs['subtotal'];
            $OrderProductDynamicDataDetail->created_by = Auth::id();

            $OrderProductDynamicDataDetail->save();

            return response()->json(['ok' => $OrderProductDynamicDataDetail->hashId]);
        }
        return response()->json(['fail' => 'Error']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException"_token" => "1flibMbJXOJMDvzSMkun2rFjEjBSrndlz3RkmggP"
     *
     * POST Payload
     *      "materialId" => "mat_KnY2dZk6MEoWx"
     *      "materialQuantity" => "1"
     *      "materialProfitMargin" => "35"
     *      "materialSubtotal" => "$33.99"
     *      "order_id" => "ord_679zRAz0JErYv"
     *      "customer_id" => "cus_B95oKZdvQJMPv"
     */
    public function post_material(Request $request)
    {
        $allInput = $request->all();

        if (!empty($allInput['materialId']))
            $material_id = Material::keyFromHashId($allInput['materialId']);

        if (!empty($allInput['order_id']))
            $order_id = Order::keyFromHashId($allInput['order_id']);

        if (!empty($allInput['customer_id']))
            $customer_id = Customer::keyFromHashId($allInput['customer_id']);

        if (!empty($material_id) && !empty($order_id) && !empty($customer_id)) {
            $material_data = Material::with('taxes')->findOrFail($material_id);
            $material_costs = $material_data->calculateCosts($allInput['materialQuantity'], $allInput['materialProfitMargin']);

            $OrderProductDynamicData = OrderProductDynamic::where('order_id', $order_id)->first();

            if (empty($OrderProductDynamicData)) {
                $OrderProductDynamicData = new OrderProductDynamic();
                $OrderProductDynamicData->order_id = $order_id;
                $OrderProductDynamicData->save();
            }
            $OrderProductDynamicDataDetail = new OrderProductDynamicDetails();

            $OrderProductDynamicDataDetail->order_product_dynamic_id = $OrderProductDynamicData->id;
            $OrderProductDynamicDataDetail->reference_type = 'catalog_materials';
            $OrderProductDynamicDataDetail->reference_id = $material_id;
            $OrderProductDynamicDataDetail->quantity = $allInput['materialQuantity'];
            $OrderProductDynamicDataDetail->cost = $material_costs['cost'];
            $OrderProductDynamicDataDetail->taxes = $material_costs['taxes'];
            $OrderProductDynamicDataDetail->profit_margin = $allInput['materialProfitMargin'] / 100;
            $OrderProductDynamicDataDetail->profit_margin_subtotal = $material_costs['profit_margin'];
            $OrderProductDynamicDataDetail->subtotal = $material_costs['subtotal'];
            $OrderProductDynamicDataDetail->created_by = Auth::id();

            $OrderProductDynamicDataDetail->save();
            return response()->json(['ok' => $OrderProductDynamicDataDetail->hashId]);
        }
        return response()->json(['fail' => 'Error']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
    public function post_product(Request $request)
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
        } catch (\Exception $e) {
            return response()->json(['fail' => $e->getMessage()]);
        }

        return response()->json(['ok' => $result]);
    }


    public function put_order(Request $request, string $hash_id = null)
    {
        $validatedData = $request->validate([
            'delivery_date' => 'date'
        ]);


        $order_record = Order::findOrFail(Order::keyFromHashId($hash_id));
        $order_record->fill($validatedData);

        $result = $order_record->save();
        if ($result)
            return response()->json(['ok' => $result]);
        else
            return response()->json(['fail' => 'sepa la verga que paso']);
    }

    // http://127.0.0.1:8000/orderdelivery_data

    /**
     * @throws UnknownHashIdConfigParameterException
     */
    public function post_delivery_data(Request $request, string $hash_id = null)
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

        if( empty( MexDistricts::keyFromHashId($allInput['mexDistrict'])) )
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
            $order_record->save();
            return response()->json(['ok' => 'La direccion de entrega se actualizo correctamente']);
        } else
            return response()->json(['fail' => 'Error al Actualizar la direccion de entrega']);
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
