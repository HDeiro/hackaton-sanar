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

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function() {
	// Unauthenticated routes here
	Route::post('login', 'AuthController@login');
	Route::post('recover', 'AuthController@recoverPassword');

	// Authenticated routes here
	// Route::group(['middleware' => ['jwt.auth']], function(){
		Route::post('logout', 'AuthController@logout');
		Route::post('refresh', 'AuthController@refresh');
		Route::post('authenticate', 'AuthController@authenticate');

		Route::resource('user', 'UserController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
		Route::resource('role', 'RoleController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
	// });
});
