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
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
    header('Access-Control-Expose-Headers: Authorization');

    Route::post('/auth/register', 'AuthenticateController@register');
    Route::post('/auth/login', 'AuthenticateController@login');
    Route::get('/auth/refresh-token', ['middleware' => 'jwt.refresh', function () {}]);

    Route::resource('players', 'PlayerController', ['only' => ['index', 'show']]);
    Route::resource('teams', 'TeamController', ['only' => ['index', 'show']]);

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::resource('custom-teams', 'CustomTeamController', ['except' => ['create', 'edit']]);
        Route::post('custom-teams/{tid}/players/{pid}', 'CustomTeamController@add_player');
        Route::get('avail-custom-teams/{pid}', 'CustomTeamController@index_available');
    });
    
});
