<?php

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

Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
Route::get('/logout', [ \App\Http\Controllers\SystemController::class, 'logout' ])->name('logout');

Route::get('/test', [
    \App\Http\Controllers\Test::class,
    'test'])->name('test');

Route::group(['middleware' => 'auth'], function () {
    Route::redirect('/', '/orders', 301);

    Route::controller(\App\Http\Controllers\OrdersController::class)->group(function () {
        Route::get('/orders','root')->name('orders_root');
        Route::post('/orders','create')->name('orders_new');
        Route::get('/orders/{hashed_id}','edit')->name('orders_edit');
    });

    Route::controller(\App\Http\Controllers\ManufacturingController::class)->group(function () {
        Route::get('/manufacturing', 'dashboard')->name('manufacturing_root');
        Route::get('/manufacturing/products', 'products')->name('manufacturing_products');
        Route::get('/manufacturing/laborcosts', 'laborcosts')->name('manufacturing_laborcosts');
        Route::get('/manufacturing/areas', 'areas')->name('manufacturing_areas');
        Route::get('/manufacturing/devices', 'devices')->name('manufacturing_devices');
        Route::get('/manufacturing/pvg', 'printvariation')->name('manufacturing_printvariation');
    });

    Route::controller(\App\Http\Controllers\MaterialsController::class)->group(function () {
        Route::get('/materials', 'root')->name('materials_root');
        Route::get('/materials/mvg', 'materialvariation')->name('materials_materialvariation');
    });

    Route::controller( \App\Http\Controllers\SystemController::class)->group(function(){
        Route::get('/system/customers', 'customers')->name('system_customers');
        Route::get('/system/suppliers', 'suppliers')->name('system_suppliers');
        Route::get('/system/taxes', 'taxes')->name('system_taxes');
        Route::get('/system/uom', 'uom')->name('system_uom');
        Route::get('/system/users', 'users')->name('system_users');
        Route::get('/system/products', 'products')->name('system_products');
    });

    Route::get('/clients', [
        App\Http\Controllers\ClientsController::class,
        'root'
    ])->name('clients_root');

    Route::controller( \App\Http\Controllers\DigitalArtController::class)->group(function(){
        Route::get('/digital_art/{id}', 'download')->name('digital_art_get');
    });
});
