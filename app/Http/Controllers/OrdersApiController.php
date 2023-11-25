<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use App\Models\Customer;
use App\Models\LaborCost;
use App\Models\Material;
use App\Models\Media;
use App\Models\MexDistricts;
use App\Models\MexMunicipalities;
use App\Models\MexState;
use App\Models\MfgDevice;
use App\Models\MfgOverhead;
use App\Models\Order;
use App\Models\OrderProductDetail;
use App\Models\OrderProductDynamic;
use App\Models\OrderProductDynamicDetails;
use App\Support\Enums\ShipmentStatusEnum;
use App\Support\Services\OrderService;
use App\Support\Workshop\OrderProductDynamicDetails\SelectDynamicProducts;
use Deligoez\LaravelModelHashId\Exceptions\UnknownHashIdConfigParameterException;
use Enmaca\LaravelUxmal\Support\Helpers\UploadS3Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrdersApiController extends Controller
{


    public
    function get_orders_event(Request $request, string $order_hashid, string $event_name )
    {
        switch( $event_name ){
            case 'order_payment_data':
            case 'order_payment_data_updated':
                $order_id = Order::keyFromHashId($order_hashid);
                OrderService::updateCostPrices($order_id);
        }
        return response()->json(['ok' => null ]);
    }
    /**
     * @throws UnknownHashIdConfigParameterException
     */
    public
    function put_order_hashid(Request $request, string $order_hashid = null): JsonResponse
    {
        $allInput = $request->all();
        $order_id = Order::keyFromHashId($order_hashid);
        if (empty($order_id))
            return response()->json(['fail' => 'El pedido no se encontro']);

        $validator = Validator::make($allInput, OrderProductDynamic::getValidationRules());

        if ($validator->fails())
            return response()->json(['fail' => $validator->messages()->toArray()]);

        $order_record = Order::findOrFail($order_id);

        if (isset($allInput['shipment_status']) && $allInput['shipment_status'] == ShipmentStatusEnum::NotNeeded->value) {
            if ($order_record->address) {
                $order_record->address->delete();
                $order_record->address_book_id = null;
            }
        }

        $order_record->fill($allInput);

        if ($order_record->save())
            return response()->json(['ok' => 'El registro se actualizo correctamente']);
        else
            return response()->json(['fail' => 'Error al actualizar el registro']);
    }





    /**
     * OrderProductDynamic
     */

    /**
     * @param Request $request
     * @param $order_hashid
     * @param $opd_hashid
     * @return JsonResponse
     * @throws UnknownHashIdConfigParameterException
     */
    public
    function get_order_product_dynamic(Request $request, $order_hashid, $opd_hashid): JsonResponse
    {
        $opd_id = OrderProductDynamic::keyFromHashId($opd_hashid);
        $order_product_dynamic = OrderProductDynamic::with(['mfg_device.area', 'media'])->findOrFail($opd_id);

        $order_product_dynamic_hashid = $order_product_dynamic->hashId;
        $array2Return['hashId'] = $order_product_dynamic_hashid;
        $array2Return['mfg_media_id_needed'] = $order_product_dynamic->mfg_media_id_needed;
        $array2Return['mfg_device_id'] = $order_product_dynamic->mfg_device->hashId ?? null;
        $array2Return['mfg_area_id'] = $order_product_dynamic->mfg_device->area->hashId ?? null;
        $array2Return['mfg_status'] = $order_product_dynamic->mfg_status;
        $array2Return['mfg_media_instructions'] = $order_product_dynamic->mfg_media_instructions;

        if( !empty( $order_product_dynamic->media ) ){
            $array2Return['media'] = [];
            foreach( $order_product_dynamic->media as $media ){
                $mediaArray = $media->toArray();
                unset($mediaArray['id']);
                $array2Return['media'][] =[
                    'hashId' => $media->hashId
                ] + $mediaArray;
            }
        }

        return response()->json([
            'ok' => 'Se obtuvo el registro correctamente',
            'result' => $array2Return //$array2Return
        ]);
    }

    /**
     * @param Request $request
     * @param $opd_hashid
     * @return JsonResponse
     * @throws UnknownHashIdConfigParameterException
     */
    public
    function put_order_product_dynamic(Request $request, $opd_hashid): JsonResponse
    {
        $allInput = $request->all();
        $opd_id = OrderProductDynamic::keyFromHashId($opd_hashid);
        /**
         * Handle HashId to Int in mfg_device_id
         */
        if (isset($allInput['mfg_device_id']) && !is_int($allInput['mfg_device_id'])) {
            $allInput['mfg_device_id'] = MfgDevice::keyFromHashId($allInput['mfg_device_id']);
        }

        $validator = Validator::make($allInput, OrderProductDynamic::getValidationRules());

        if ($validator->fails())
            return response()->json(['fail' => $validator->messages()->toArray()]);

        $order_product_dynamic = OrderProductDynamic::findOrFail($opd_id);

        $order_product_dynamic->fill($allInput);

        if (isset($allInput['mfg_status']) && $allInput['mfg_status'] == 'not_needed') {
            $order_product_dynamic->mfg_device_id = null;
            $order_product_dynamic->mfg_media_id_needed = 'no';
        }

        if (isset($allInput['mfg_media_id_needed']) && $allInput['mfg_media_id_needed'] == 'no') {
            // TODO: Check if there is a media_id and delete it
        }

        $order_product_dynamic->save();

        return response()->json(['ok' => 'El producto dinamico se actualizo correctamente']);
    }

    /**
     * @throws UnknownHashIdConfigParameterException
     */
    public
    function put_order_delivery_data(Request $request, string $order_hashid = null)
    {
        $allInput = $request->all();

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
        }

        $address_record->recipient_data_same_as_customer = $allInput['recipientDataSameAsCustomer'] ?? 0;

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

    /**
     * @param Request $request
     * @param string $order_hashid
     * @param string $opd_hashid
     * @return JsonResponse
     * @throws \Exception
     */
    public
    function post_order_product_dynamic_hashid_media(Request $request, string $order_hashid, string $opd_hashid): JsonResponse
    {
        if (!$request->hasFile('file'))
            throw new \Exception('No se ha enviado ningún archivo');

        try {
            $file = $request->file('file');
            $metadata = UploadS3Helper::upload(
                file: $file,
                aws_key: config('workshop.aws.key'),
                aws_secret: config('workshop.aws.secret'),
                aws_region: config('workshop.aws.region'),
                s3_bucket: config('workshop.buckets.media'),
                s3_options: [
                    'ACL' => 'public-read',
                    'CacheControl' => 'max-age=0'
                ]
            );

            $opd_id = OrderProductDynamic::keyFromHashId($opd_hashid);

            $media = new Media();
            $media->name = $file->getClientOriginalName();
            $media->related_type = 'order_product_dynamic';
            $media->related_id = $opd_id;
            $media->path = $metadata['effectiveUri'];
            $media->category = 'customer_reference';
            $media->preview_path = $metadata['effectiveUri'];
            $media->content_type = $metadata['headers']['content-type'];
            $media->size = $metadata['headers']['content-length'];
            $media->save();

            return response()->json(['ok' => [
                'url' => $metadata['effectiveUri']
            ]], 200);

        } catch (\Exception $e) {
            // Manejo del error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws UnknownHashIdConfigParameterException"_token" => "1flibMbJXOJMDvzSMkun2rFjEjBSrndlz3RkmggP"
     *
     * POST Payload
     *      "materialId" => "mat_KnY2dZk6MEoWx"
     *      "materialQuantity" => "1"
     *      "materialProfitMargin" => "35"
     *      "materialSubtotal" => "$33.99"
     *      "order_id" => "ord_679zRAz0JErYv"
     *      "customer_id" => "cus_B95oKZdvQJMPv"
     */
    public
    function post_orders_opdd_material(Request $request)
    {
        $allInput = $request->all();

        if (!empty($allInput['materialId']))
            $material_id = Material::keyFromHashId($allInput['materialId']);

        if (!empty($allInput['order_id']))
            $order_id = Order::keyFromHashId($allInput['order_id']);

        if (!empty($allInput['customer_id']))
            $customer_id = Customer::keyFromHashId($allInput['customer_id']);

        $opd_id = null;
        if (!empty($allInput['opd_id']))
            $opd_id = OrderProductDynamic::keyFromHashId($allInput['opd_id']);

        if (!empty($material_id) && !empty($order_id) && !empty($customer_id)) {
            $material_data = Material::with('taxes')->findOrFail($material_id);
            $material_costs = $material_data->calculateCosts($allInput['materialQuantity'], $allInput['materialProfitMargin']);

            if (empty($opd_id)) {
                $OrderProductDynamicData = new OrderProductDynamic();
                $OrderProductDynamicData->order_id = $order_id;
                $OrderProductDynamicData->save();
                $opd_id = $OrderProductDynamicData->id;
            }

            $OrderProductDynamicDataDetail = new OrderProductDynamicDetails();
            $OrderProductDynamicDataDetail->order_product_dynamic_id = $opd_id;
            $OrderProductDynamicDataDetail->reference_type = 'catalog_materials';
            $OrderProductDynamicDataDetail->reference_id = $material_id;
            $OrderProductDynamicDataDetail->quantity = $allInput['materialQuantity'];
            $OrderProductDynamicDataDetail->cost = $material_costs['cost'];
            $OrderProductDynamicDataDetail->taxes = $material_costs['taxes'];
            $OrderProductDynamicDataDetail->profit_margin = $allInput['materialProfitMargin'] / 100;
            $OrderProductDynamicDataDetail->profit_margin_subtotal = $material_costs['profit_margin'];
            $OrderProductDynamicDataDetail->subtotal = $material_costs['subtotal'];
            $OrderProductDynamicDataDetail->price = $material_costs['price'];
            $OrderProductDynamicDataDetail->created_by = Auth::id();
            $OrderProductDynamicDataDetail->save();

            OrderService::updateCostPrices($order_id);

            return response()->json([
                'ok' => 'Se agrego correctamente el material al producto dinámico',
                'result' => [
                    'opdd_id' => $OrderProductDynamicDataDetail->hashId
                ]]);
        }
        return response()->json(['fail' => 'Error']);
    }

    /**
     * @param Request $request
     *      [laborCostId] => lab_XXXXXX
     *      [laborCostQuantity] => 15
     *      [laborCostSubtotal] => $18.13
     *      [order_id] => ord_XXXXX
     *      [customer_id] => cus_XXXXX
     * @return JsonResponse
     * @throws UnknownHashIdConfigParameterException
     */
    public
    function post_orders_opdd_labor_cost(Request $request, string $order_hashid )
    {
        $allInput = $request->all();

        if (!empty($allInput['laborCostId']))
            $catalog_labor_cost_id = LaborCost::keyFromHashId($allInput['laborCostId']);

        if (!empty($allInput['order_id']))
            $order_id = Order::keyFromHashId($allInput['order_id']);

        if (!empty($allInput['customer_id']))
            $customer_id = Customer::keyFromHashId($allInput['customer_id']);

        $opd_id = null;
        if (!empty($allInput['opd_id']))
            $opd_id = OrderProductDynamic::keyFromHashId($allInput['opd_id']);

        if (!empty($catalog_labor_cost_id) && !empty($order_id) && !empty($customer_id)) {
            $labor_cost_data = LaborCost::with('taxes')->findOrFail($catalog_labor_cost_id);
            $labor_costs = $labor_cost_data->calculateCosts($allInput['laborCostQuantity']);

            if (empty($opd_id)) {
                $OrderProductDynamicData = new OrderProductDynamic();
                $OrderProductDynamicData->order_id = $order_id;
                $OrderProductDynamicData->save();
                $opd_id = $OrderProductDynamicData->id;
            }

            $OrderProductDynamicData = OrderProductDynamic::where('order_id', $order_id)->first();

            if (empty($OrderProductDynamicData)) {
                $OrderProductDynamicData = new OrderProductDynamic();
                $OrderProductDynamicData->order_id = $order_id;
                $OrderProductDynamicData->save();
            }

            $OrderProductDynamicDataDetail = new OrderProductDynamicDetails();

            $OrderProductDynamicDataDetail->order_product_dynamic_id = $opd_id;
            $OrderProductDynamicDataDetail->reference_type = 'catalog_labor_costs';
            $OrderProductDynamicDataDetail->reference_id = $catalog_labor_cost_id;
            $OrderProductDynamicDataDetail->quantity = $allInput['laborCostQuantity'];
            $OrderProductDynamicDataDetail->cost = $labor_costs['cost'];
            $OrderProductDynamicDataDetail->taxes = $labor_costs['taxes'];
            $OrderProductDynamicDataDetail->profit_margin = $labor_costs['profit_margin'];
            $OrderProductDynamicDataDetail->subtotal = $labor_costs['subtotal'];
            $OrderProductDynamicDataDetail->price = $labor_costs['price'];
            $OrderProductDynamicDataDetail->created_by = Auth::id();

            $OrderProductDynamicDataDetail->save();

            OrderService::updateCostPrices($order_id);
            return response()->json([
                'ok' => 'Se agrego correctamente la mano de obra al producto dinámico',
                'result' => [
                    'opdd_id' => $OrderProductDynamicDataDetail->hashId
                ]
            ]);
        }
        return response()->json(['fail' => 'No se pudo agregar correctamente la mano de obra']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws UnknownHashIdConfigParameterException
     *
     */
    public
    function post_orders_opdd_mfgoverhead(Request $request, string $order_hashid)
    {
        $allInput = $request->all();
        $opd_id = null;
        if (!empty($allInput['opd_id']))
            $opd_id = OrderProductDynamic::keyFromHashId($allInput['opd_id']);

        if (!empty($allInput['mfgOverheadId']))
            $mfg_overhead_cost_id = MfgOverhead::keyFromHashId($allInput['mfgOverheadId']);

        if (!empty($allInput['order_id']))
            $order_id = Order::keyFromHashId($allInput['order_id']);

        if (!empty($allInput['customer_id']))
            $customer_id = Customer::keyFromHashId($allInput['customer_id']);

        if (!empty($mfg_overhead_cost_id) && !empty($order_id) && !empty($customer_id)) {
            $mfg_overhead_data = MfgOverhead::with('taxes')->findOrFail($mfg_overhead_cost_id);
            $mfg_overhead_costs = $mfg_overhead_data->calculateCosts($allInput['mfgOverheadQuantity']);

            if (empty($opd_id)) {
                $OrderProductDynamicData = new OrderProductDynamic();
                $OrderProductDynamicData->order_id = $order_id;
                $OrderProductDynamicData->save();
                $opd_id = $OrderProductDynamicData->id;
            }

            $OrderProductDynamicDataDetail = new OrderProductDynamicDetails();

            $OrderProductDynamicDataDetail->order_product_dynamic_id = $opd_id;
            $OrderProductDynamicDataDetail->reference_type = 'mfg_overhead';
            $OrderProductDynamicDataDetail->reference_id = $mfg_overhead_cost_id;
            $OrderProductDynamicDataDetail->quantity = $allInput['mfgOverheadQuantity'];
            $OrderProductDynamicDataDetail->cost = $mfg_overhead_costs['cost'];
            $OrderProductDynamicDataDetail->taxes = $mfg_overhead_costs['taxes'];
            $OrderProductDynamicDataDetail->profit_margin = $mfg_overhead_costs['profit_margin'];
            $OrderProductDynamicDataDetail->subtotal = $mfg_overhead_costs['subtotal'];
            $OrderProductDynamicDataDetail->price = $mfg_overhead_costs['price'];
            $OrderProductDynamicDataDetail->created_by = Auth::id();

            $OrderProductDynamicDataDetail->save();

            OrderService::updateCostPrices($order_id);
            return response()->json([
                'ok' => 'Se agrego correctamente el costo indirecto al producto dinámico',
                'result' => [
                    'opdd_id' => $OrderProductDynamicDataDetail->hashId
                ]
            ]);
        }
        return response()->json(['fail' => 'Error']);
    }

    /**
     * @param Request $request
     * @param string $order_hashid
     * @param string $oprd_hashid
     * @return JsonResponse
     * @throws UnknownHashIdConfigParameterException <a href="http://127.0.0.1:8000/orders/dynamic_detail/ord_4WmvDA86E98xo">http://127.0.0.1:8000/orders/dynamic_detail/ord_4WmvDA86E98xo</a>
     */
    public function delete_order_product_detail(Request $request, string $order_hashid, string $oprd_hashid)
    {
        $order_product_detail_id = OrderProductDetail::keyFromHashId($oprd_hashid);
        $order_product_row = OrderProductDetail::with('order')->findOrFail($order_product_detail_id);
        if ($order_product_row) {
            if ($order_product_row->delete()) {
                OrderService::updateCostPrices($order_product_row->order->id);
                return response()->json(['ok' => 'El registro se elimino correctamente']);
            } else
                return response()->json(['fail' => 'El registro no se pude eliminar']);
        }
        return response()->json([
            'warning' => 'El registro no se encontro',
            'debug' => $order_product_detail_id
        ]);
    }

    /**
     * @param Request $request
     * @param string $order_hashedId
     * @param string $opd_hashedId
     * @param string $opdd_hashedId
     * @return JsonResponse
     * @throws UnknownHashIdConfigParameterException <a href="http://127.0.0.1:8000/orders/dynamic_detail/ord_4WmvDA86E98xo">http://127.0.0.1:8000/orders/dynamic_detail/ord_4WmvDA86E98xo</a>
     */
    public function delete_order_product_dynamic_detail(Request $request, string $order_hashedId, string $opd_hashedId, string $opdd_hashedId)
    {
        $order_product_dynamic_id = OrderProductDynamicDetails::keyFromHashId($opdd_hashedId);
        $order_product_dynamic_row = OrderProductDynamicDetails::with('order_product_dynamic')->find($order_product_dynamic_id);
        if ($order_product_dynamic_row) {
            if ($order_product_dynamic_row->delete()) {
                OrderService::updateCostPrices($order_product_dynamic_row->order_product_dynamic->order_id);
                return response()->json(['ok' => 'El registro se elimino correctamente']);
            } else
                return response()->json(['fail' => 'El registro no se pude eliminar']);
        }
        return response()->json(['warning' => 'El registro no se encontro']);
    }


    /**
     * @param Request $request
     * @param $hashed_id
     * @return JsonResponse
     */
    public
    function post_order_product_dynamic_search(Request $request, $order_hashid)
    {
        $allInput = $request->all();

        $searchObj = new SelectDynamicProducts(
            values: ['order_id' => $order_hashid]
        );
        return response()->json($searchObj->search());
    }

}
