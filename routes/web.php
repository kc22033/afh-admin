<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['web', 'auth']], function() {

	Route::get('/admin/user/create', [
		'uses' => 'Admin\UserController@index', 
		'as' => 'admin.user.create'
	]);

	// Route::get('/home', 'HomeController@index');

	// // Route::get('/animals', 'AnimalController@index');
	// Route::get('/animals/edit', 'AnimalController@edit');
	// Route::get('/animals/clone/{id}', 'AnimalController@clone');
	// Route::post('/upload', 'ImageController@upload');

	// Route::get('/breed/no-description/{breed}', function ($breed) {
	// 	return "No description information available for breed " . $breed;
	// });

});

// Route::get(
// 	'/images/{file}', 
// 	'ImageController@getImage'
// );

Route::get(
	'/images/storage/{file}', 
	'ImageController@getImage'
);