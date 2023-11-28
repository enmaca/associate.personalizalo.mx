<?php

use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\ManufacturingAreasController;
use App\Http\Controllers\ManufacturingDevicesController;
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
Route::get('/logout', [SystemController::class, 'logout'])->name('logout');

Route::controller(Test::class)->group(function () {
    Route::get('/test', 'test')->name('test');
    Route::post('/test/tomselect_load', 'tomselect_load')->name('test_tomselect_load');
    Route::post('/test/dropzone', 'dropzone')->name('test_dropzone');
    Route::get('/test/signed-url', 'signed_url')->name('test_signed_url');
});

Route::group(['middleware' => 'auth'], function () {
    Route::redirect('/', '/orders', 301);

    Route::controller(OrdersController::class)->group(function () {
        Route::get('/orders/{order_hashid}', 'get_orders')->name('web_get_orders');
        Route::get('/orders', 'get_orders_dashboard')->name('web_get_orders_dashboard');

        Route::post('/orders/product', 'post_product')->name('orders_post_product');
        Route::post('/orders/put_payment', 'put_payment')->name('orders_put_payment');

    });

    Route::controller(ManufacturingController::class)->group(function () {
        Route::get('/manufacturing', 'dashboard')->name('manufacturing_root');
        Route::get('/manufacturing/products', 'products')->name('manufacturing_products');
        Route::get('/manufacturing/laborcosts', 'laborcosts')->name('manufacturing_laborcosts');
        Route::get('/manufacturing/areas', 'areas')->name('manufacturing_areas');
        Route::get('/manufacturing/devices', 'devices')->name('manufacturing_devices');
        Route::get('/manufacturing/pvg', 'printvariation')->name('manufacturing_printvariation');
    });

    Route::controller(ManufacturingAreasController::class)->group(function () {
        Route::post('/mfg_area/search_tomselect', 'search_tomselect')->name('mfg_area_search_tomselect');
    });

    Route::controller(ManufacturingDevicesController::class)->group(function () {
        Route::post('/mfg_devices/search_tomselect', 'search_tomselect')->name('mfg_devices_search_tomselect');
    });

    Route::controller(MaterialsController::class)->group(function () {
        Route::get('/material', 'root')->name('material_root');
        Route::post('/material/search_tomselect', 'search_tomselect')->name('material_search_tomselect');
        Route::get('/material/mvg', 'mvg')->name('material_variation_group');
    });

    Route::controller(SystemController::class)->group(function () {
        Route::get('/system/customers', 'customers')->name('system_customers');
        Route::get('/system/suppliers', 'suppliers')->name('system_suppliers');
        Route::get('/system/taxes', 'taxes')->name('system_taxes');
        Route::get('/system/uom', 'uom')->name('system_uom');
        Route::get('/system/users', 'users')->name('system_users');
        Route::get('/system/products', 'products')->name('system_products');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer', 'root')->name('customers');
        Route::get('/customer/{id}', 'get_id')->name('customer_get_id');
        Route::post('/customer/search_tomselect', 'search_tomselect')->name('customer_search_tomselect');
    });

    Route::controller(ProductsController::class)->group(function () {
        Route::get('/products', 'root')->name('products');
        Route::get('/products/{id}', 'get_id')->name('products_get_id');
        Route::post('/products/search_tomselect', 'search_tomselect')->name('products_search_tomselect');
    });

    Route::controller(DigitalArtController::class)->group(function () {
        Route::get('/digital_art/{id}', 'download')->name('digital_art_get');
    });

    Route::controller(AddressBookController::class)->group(function () {
        Route::post('/address_book/mex_municipality/search_tomselect', 'search_tomselect_mex_municipality')->name('mex_municipality_search_tomselect');
        Route::post('/address_book/mex_state/search_tomselect', 'search_tomselect_mex_state')->name('mex_state_search_tomselect');
        Route::post('/address_book/mex_district/search_tomselect', 'search_tomselect_mex_district')->name('mex_district_search_tomselect');
    });

    Route::controller(PaymentMethodController::class)->group(function () {
        Route::post('/payment_method/search_tomselect', 'search_tomselect')->name('payment_method_search_tomselect');
    });
});
