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
    
});

