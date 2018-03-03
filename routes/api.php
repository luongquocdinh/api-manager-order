<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (Request $request) {
    return response()->json([
        'domain' => 'Medicine Api',
        'method' => 'GET'
    ], 200);
});
Route::post('/', function (Request $request) {
    return response()->json([
        'domain' => 'Medicine Api',
        'method' => 'POST'
    ], 200);
});

Route::group(['middleware' => ['cors'], 'prefix' => 'v1'], function () {
    Route::post('register', 'v1\Auth\UserController@register');
    Route::post('login', 'v1\Auth\UserController@login');
});

Route::group(['middleware' => ['jwt.auth', 'cors', 'role:admin'], 'prefix' => 'v1'], function () {
    Route::post('addRoles', 'v1\Auth\RoleController@addRole');
});

Route::group(['middleware' => ['jwt.auth', 'cors', 'role:partner'], 'prefix' => 'v1'], function () {
    // Product
    Route::get('products', 'v1\MasterData\ProductController@getList');
    Route::get('productAll', 'v1\MasterData\ProductController@getListAll');
    Route::get('product/{id}', 'v1\MasterData\ProductController@findProductById');
    Route::post('product', 'v1\MasterData\ProductController@store');
    Route::put('product/{id}', 'v1\MasterData\ProductController@update');

    // Customer
    Route::get('customers', 'v1\Partner\CustomerController@getList');
    Route::get('customerAll', 'v1\Partner\CustomerController@getListAll');
    Route::post('customerDetail', 'v1\Partner\CustomerController@findCustomerById');
    Route::post('customer', 'v1\Partner\CustomerController@store');
    Route::put('customer', 'v1\Partner\CustomerController@update');

    // Order
    Route::get('orders', 'v1\Partner\OrderController@getList');
    Route::get('orderAll', 'v1\Partner\OrderController@getListAll');
    Route::get('order/{id}', 'v1\Partner\OrderController@findProductById');
    Route::post('order', 'v1\Partner\OrderController@store');
    Route::put('order/{id}', 'v1\Partner\OrderController@update');
    Route::post('order/customer', 'v1\Partner\OrderController@getListOrderByCustomer');
});

