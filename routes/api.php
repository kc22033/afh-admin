<?php

use Illuminate\Http\Request;


/*
--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
}
);

Route::group(['namespace' => 'Api'], function() 
{
	Route::put('animals/updateStatus/{animal}', 'AnimalController@updateStatus');
	Route::resource('animals', 'AnimalController');
	
	Route::get('dashboard/{species?}/{status?}', 'DashboardController@index');
	Route::get('species', 'SpeciesController@index');
	Route::get('animals/', 'AnimalController@index');
	Route::get('breeds/{species?}', 'BreedController@index');
	Route::get('status', 'StatusController@index');
	Route::get('genders', 'GenderController@index');
	Route::get('/profile', 'ProfileController@getUser');
}
);
