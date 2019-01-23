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

Route::middleware('jwt.auth')->get('users', function () {
    return auth('api')->user();
});

// API route group that we need to protect
Route::group(['prefix' => 'v1', 'middleware' => ['ability:admin,create-users']], function()
{

    // Route to create a new role
    Route::post('role', 'Auth\JwtAuthenticateController@createRole');
    // Route to create a new permission
    Route::post('permission', 'Auth\JwtAuthenticateController@createPermission');
    // Route to assign role to user
    Route::post('assign-role', 'Auth\JwtAuthenticateController@assignRole');
    // Route to attache permission to a role
    Route::post('attach-permission', 'Auth\JwtAuthenticateController@attachPermission');



    // Protected route
    Route::get('users', 'Auth\JwtAuthenticateController@index');
});

// Authentication route
Route::group(['prefix' => 'v1'], function()
{
    // Protected route
    Route::post('login', 'Auth\JwtAuthenticateController@authenticate');
    //Route::post('login', 'APILoginController@login');
});


