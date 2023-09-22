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
Route::get('/logout', [
    App\Http\Controllers\HomeController::class,
    'logout'
])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [
        App\Http\Controllers\HomeController::class,
        'root'
    ])->name('home_index');

    Route::get('/orders', [
        App\Http\Controllers\OrdersController::class,
        'root'
    ])->name('orders_root');

    Route::get('/clients', [
        App\Http\Controllers\ClientsController::class,
        'root'
    ])->name('clients_root');
});
