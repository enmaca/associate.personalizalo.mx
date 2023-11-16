<?php

use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DigitalArtController;
use App\Http\Controllers\ManufacturingController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\Test;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', Login::class)->name('login');
Route::get('/logout', [ SystemController::class, 'logout' ])->name('logout');

Route::get('/test', [
    Test::class,
    'test'])->name('test');
Route::post('/test/tomselect_load', [
    Test::class,
    'tomselect_load'])->name('test_tomselect_load');

Route::group(['middleware' => 'auth'], function () {
    Route::redirect('/', '/orders', 301);

    Route::controller(OrdersController::class)->group(function () {
        Route::get('/orders','root')->name('orders_root');
        Route::put('/orders/{hashed_id}','put_order')->name('put_order');
        Route::post('/orders','create')->name('orders_create');
        Route::get('/orders/{hashed_id}','edit')->name('orders_edit');
        Route::post('/orders/laborcost','post_labor_cost')->name('orders_post_labor_cost');
        Route::delete('/orders/dynamic_detail/{opdd_id}','delete_dynamic_detail_row')->name('order_delete_product_dynamic_detail');
        Route::delete('/orders/product_detail/{opd_id}','delete_product_detail_row')->name('order_delete_product_detail_detail');
        Route::post('/orders/mfgoverhead','post_mfg_overhead')->name('orders_post_mfg_overhead');
        Route::post('/orders/material','post_material')->name('orders_post_material');
        Route::post('/orders/product','post_product')->name('orders_post_product');
        Route::post('/orders/delivery_data','post_delivery_data')->name('orders_post_delivery_data');
        Route::post('/orders/put_payment','put_payment')->name('orders_put_payment');
    });

    Route::controller(ManufacturingController::class)->group(function () {
        Route::get('/manufacturing', 'dashboard')->name('manufacturing_root');
        Route::get('/manufacturing/products', 'products')->name('manufacturing_products');
        Route::get('/manufacturing/laborcosts', 'laborcosts')->name('manufacturing_laborcosts');
        Route::get('/manufacturing/areas', 'areas')->name('manufacturing_areas');
        Route::get('/manufacturing/devices', 'devices')->name('manufacturing_devices');
        Route::get('/manufacturing/pvg', 'printvariation')->name('manufacturing_printvariation');
    });

    Route::controller(MaterialsController::class)->group(function () {
        Route::get('/material', 'root')->name('material_root');
        Route::post('/material/search_tomselect', 'search_tomselect')->name('material_search_tomselect');
        Route::get('/material/mvg', 'mvg')->name('material_variation_group');
    });

    Route::controller( SystemController::class)->group(function(){
        Route::get('/system/customers', 'customers')->name('system_customers');
        Route::get('/system/suppliers', 'suppliers')->name('system_suppliers');
        Route::get('/system/taxes', 'taxes')->name('system_taxes');
        Route::get('/system/uom', 'uom')->name('system_uom');
        Route::get('/system/users', 'users')->name('system_users');
        Route::get('/system/products', 'products')->name('system_products');
    });

    Route::controller( CustomerController::class)->group(function(){
        Route::get('/customer', 'root')->name('customers');
        Route::get('/customer/{id}', 'get_id')->name('customer_get_id');
        Route::post('/customer/search_tomselect', 'search_tomselect')->name('customer_search_tomselect');
    });

    Route::controller( ProductsController::class)->group(function(){
        Route::get('/products', 'root')->name('products');
        Route::get('/products/{id}', 'get_id')->name('products_get_id');
        Route::post('/products/search_tomselect', 'search_tomselect')->name('products_search_tomselect');
    });

    Route::controller( DigitalArtController::class)->group(function(){
        Route::get('/digital_art/{id}', 'download')->name('digital_art_get');
    });

    Route::controller(AddressBookController::class)->group(function(){
        Route::post('/address_book/mex_municipality/search_tomselect', 'search_tomselect_mex_municipality')->name('mex_municipality_search_tomselect');
        Route::post('/address_book/mex_state/search_tomselect', 'search_tomselect_mex_state')->name('mex_state_search_tomselect');
        Route::post('/address_book/mex_district/search_tomselect', 'search_tomselect_mex_district')->name('mex_district_search_tomselect');
    });

    Route::controller(PaymentMethodController::class)->group(function(){
        Route::post('/payment_method/search_tomselect', 'search_tomselect')->name('payment_method_search_tomselect');
    });
});
