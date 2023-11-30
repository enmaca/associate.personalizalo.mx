<?php

use App\Http\Controllers\CustomerApiController;
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
    Route::post('/orders', 'post_order')->name('api_post_order');
    Route::put('/orders/{order_hashid}', 'put_order_hashid')->name('api_put_order');
    Route::put('/orders/{order_hashid}/delivery_data', 'put_order_delivery_data')->name('api_put_order_delivery_data');
    Route::get('/orders/{order_hashid}/event/{event_name}', 'get_order_event')->name('api_get_order_event');
    Route::post('/orders/{order_hashid}/put_payment', 'put_order_payment')->name('api_put_order_payment');

    /** OrderProduct */
    // Route::delete('/orders/product_detail/{opdd_hashed_id}', 'delete_product_detail_row')->name('order_delete_product_detail_detail');
    Route::delete('/orders/{order_hashid}/product/{oprd_hashid}', 'delete_order_product_detail')->name('api_delete_order_product_detail');

    /** OrderProductDynamic */
    Route::post('/orders/{order_hashid}/opd', 'post_order_opd')->name('api_post_order_opd');
    Route::post('/orders/{order_hashid}/opd/material', 'post_order_opd_material')->name('api_post_order_opd_material');
    Route::post('/orders/{order_hashid}/opd/laborcost', 'post_order_opd_labor_cost')->name('api_post_order_opd_labor_cost');
    Route::post('/orders/{order_hashid}/opd/mfgoverhead', 'post_order_opd_mfgoverhead')->name('api_post_order_opd_mfgoverhead');
    Route::post('/orders/{order_hashid}/opd/search', 'post_order_opd_search')->name('api_post_order_opd_search');
    Route::post('/orders/{order_hashid}/opd/{opd_hashid}/media', 'post_order_opd_media')->name('api_post_order_opd_media');
    Route::get('/orders/{order_hashid}/opd/{opd_hashid}', 'get_order_opd')->name('api_get_order_opd');
    Route::put('/orders/{order_hashid}/opd/{opd_hashid}', 'put_order_opd')->name('api_put_order_opd');

    /** OrderProductDynamicDetail */
    Route::delete('/orders/{order_hashid}/opd/{opd_hashid}/detail/{opdd_id}', 'delete_order_opdd')->name('api_delete_order_opdd');
});

Route::controller(CustomerApiController::class)->group(function () {
    Route::get('/customer/{customer_hashid}', 'get_customer')->name('api_get_customer');
});


Route::controller(\App\Http\Controllers\UtilsController::class)->group(function () {
    Route::get('/get-routes','get_routes')->name('api_routes');
});

