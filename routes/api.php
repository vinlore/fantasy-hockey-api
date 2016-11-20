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

Route::group(['middleware' => ['api']], function () {

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

    Route::post('/auth/register', 'AuthenticateController@register');
    Route::post('/auth/login', 'AuthenticateController@login');

    Route::resource('players', 'PlayerController', ['only' => ['index', 'show']]);
    
});
