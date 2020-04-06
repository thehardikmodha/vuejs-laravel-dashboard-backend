<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('auth/login', 'Api\AuthController@login');

Route::group([
    'middleware' => ['auth:sanctum'],
    'namespace' => 'Api',
],function () {

    Route::post('auth/logout', 'AuthController@logout');

    Route::get('auth/user', 'AuthController@userData');

    // Role resource
    Route::resource('roles', 'RoleController');

    // Role resource
    Route::apiResource('users', 'UserController');

});
