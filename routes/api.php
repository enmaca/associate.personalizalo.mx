<?php

use App\Http\Controllers\OrdersApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(OrdersApiController::class)->group(function () {
    /** Order */
    Route::get('/orders/{order_hashid}/event/{event_name}', 'get_orders_event')->name('api_get_orders_event');
    Route::put('/orders/{order_hashid}', 'put_order_hashid')->name('api_put_order');

    /** OrderProduct */
    // Route::delete('/orders/product_detail/{opdd_hashed_id}', 'delete_product_detail_row')->name('order_delete_product_detail_detail');
    Route::delete('/orders/{order_hashid}/product/{oprd_hashid}', 'delete_order_product_detail')->name('api_delete_order_product_detail');

    Route::put('/orders/{order_hashid}/delivery_data', 'put_order_delivery_data')->name('api_put_order_delivery_data');


    /** OrderProductDynamic */
    Route::post('/orders/{order_hashid}/opd/material', 'post_orders_opdd_material')->name('api_post_orders_material');
    Route::post('/orders/{order_hashid}/opd/laborcost', 'post_orders_opdd_labor_cost')->name('api_post_orders_labor_cost');
    Route::post('/orders/{order_hashid}/opd/mfgoverhead', 'post_orders_opdd_mfgoverhead')->name('api_post_orders_mfgoverhead');
    Route::post('/orders/{order_hashid}/opd/{opd_hashid}/media', 'post_order_product_dynamic_hashid_media')->name('api_post_order_product_dynamic_media');
    Route::post('/orders/{order_hashid}/opd/search', 'post_order_product_dynamic_search')->name('api_post_order_product_dynamic_search');
    Route::get('/orders/{order_hashid}/opd/{opd_hashid}', 'get_order_product_dynamic')->name('api_get_order_product_dynamic');
    Route::put('/orders/{order_hashid}/opd/{opd_hashid}', 'put_order_product_dynamic')->name('api_put_order_product_dynamic');

    /** OrderProductDynamicDetail */
    Route::delete('/orders/{order_hashid}/opd/{opd_hashid}/detail/{opdd_id}', 'delete_order_product_dynamic_detail')->name('api_delete_order_product_dynamic_detail');



});

Route::controller(\App\Http\Controllers\UtilsController::class)->group(function () {
    Route::get('/get-routes','get_routes')->name('api_routes');
});

