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
    Route::post('sendCode', 'v1\Auth\UserController@sendCode');
    Route::post('reset-password', 'v1\Auth\UserController@resetPassword');
});

Route::group(['middleware' => ['jwt.auth', 'cors', 'role:admin'], 'prefix' => 'v1'], function () {
    Route::post('addRoles', 'v1\Auth\RoleController@addRole');
});

Route::group(['middleware' => ['cors'], 'prefix' => 'v1'], function () {
    // Product
    Route::get('products', 'v1\MasterData\ProductController@getList');
    Route::get('productAll', 'v1\MasterData\ProductController@getListAll');
    Route::get('product/{id}', 'v1\MasterData\ProductController@findProductById');
    Route::post('product', 'v1\MasterData\ProductController@store');
    Route::put('product/{id}', 'v1\MasterData\ProductController@update');
});

Route::group(['middleware' => ['jwt.auth', 'cors', 'role:manager'], 'prefix' => 'v1'], function () {
    Route::put('user/update', 'v1\Auth\UserController@update');
    Route::post('user/addUser', 'v1\Auth\UserController@addUser');
    Route::get('user/detail', 'v1\Auth\UserController@detail');
});

Route::group(['middleware' => ['jwt.auth', 'cors', 'role:partner|manager|admin'], 'prefix' => 'v1'], function () {
    
    // User
    Route::put('user/change-password', 'v1\Auth\UserController@changePassword');
    Route::post('/user/find', 'v1\Auth\UserController@find');

    // Customer
    Route::get('customers', 'v1\Partner\CustomerController@getList');
    Route::get('customerAll', 'v1\Partner\CustomerController@getListAll');
    Route::post('customerDetail', 'v1\Partner\CustomerController@findCustomerById');
    Route::post('customer', 'v1\Partner\CustomerController@store');
    Route::put('customer', 'v1\Partner\CustomerController@update');
    Route::delete('customer/delete', 'v1\Partner\CustomerController@destroy');

    // Order
    Route::get('orders', 'v1\Partner\OrderController@getList');
    Route::get('orderAll', 'v1\Partner\OrderController@getListAll');
    Route::get('order/{id}', 'v1\Partner\OrderController@findProductById');
    Route::post('order', 'v1\Partner\OrderController@store');
    Route::put('order/{id}', 'v1\Partner\OrderController@update');
    Route::post('order/customer', 'v1\Partner\OrderController@getListOrderByCustomer');
    Route::delete('order/delete', 'v1\Partner\OrderController@destroy');
    Route::post('/order/byDate', 'v1\Partner\OrderController@getOrderByDate');

    // Outlet Product
    Route::get('outlet-product', 'v1\Partner\OutletProductController@getList');
    Route::post('outlet-product', 'v1\Partner\OutletProductController@store');
    Route::get('outlet-product/{id}', 'v1\Partner\OutletProductController@findProductById');
    Route::put('outlet-product/{id}', 'v1\Partner\OutletProductController@update');
    Route::delete('outlet-product/{id}', 'v1\Partner\OutletProductController@destroy');

    // Statistic
    Route::post('byDate', 'v1\Partner\StatisticController@byDate');
    Route::post('byMonth', 'v1\Partner\StatisticController@byMonth');
    Route::post('byYear', 'v1\Partner\StatisticController@byYear');

    // Supplier
    Route::post('list-supplier', 'v1\Partner\SupplierController@paginate');
    Route::get('supplierAll', 'v1\Partner\SupplierController@getListAll');
    Route::post('suppliers', 'v1\Partner\SupplierController@store');
    Route::post('supplier', 'v1\Partner\SupplierController@findById');
    Route::put('supplier', 'v1\Partner\SupplierController@update');
});

