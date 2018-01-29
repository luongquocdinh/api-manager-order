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
        'method' => 'GET',
        'data' => JWTAuth::toUser($request->token)
    ], 200);
});
Route::post('/', function (Request $request) {
    return response()->json([
        'domain' => 'Medicine Api',
        'method' => 'POST'
    ], 200);
});

Route::post('v1/sign-up', 'v1\Auth\UserController@register');
Route::post('v1/login', 'v1\Auth\UserController@login');

Route::group(['middleware' => ['jwt.auth', 'role:admin'], 'prefix' => 'v1'], function () {
    Route::post('addRoles', 'v1\Auth\RoleController@addRole');
    
    // Product
    Route::get('products', 'v1\MasterData\ProductController@getList');
    Route::get('product/{id}', 'v1\MasterData\ProductController@findProductById');
    Route::post('product', 'v1\MasterData\ProductController@store');
    Route::put('product/{id}', 'v1\MasterData\ProductController@update');
});

Route::group(['middleware' => ['jwt.auth', 'role:partner'], 'prefix' => 'v1'], function () {
    // Customer
    Route::get('customers', 'v1\Partner\CustomerController@getList');
    Route::get('customer/{id}', 'v1\Partner\CustomerController@findProductById');
    Route::post('customer', 'v1\Partner\CustomerController@store');
    Route::put('customer/{id}', 'v1\Partner\CustomerController@update');

    // Order
    Route::get('orders', 'v1\Partner\OrderController@getList');
    Route::get('order/{id}', 'v1\Partner\OrderController@findProductById');
    Route::post('order', 'v1\Partner\OrderController@store');
    Route::put('order/{id}', 'v1\Partner\OrderController@update');
});

