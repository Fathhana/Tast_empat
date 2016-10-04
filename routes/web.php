<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
route::get('/', function(){
	return redirect()->to('/crud');
});
// Route::resource('crud', 'CrudController');
Route::get('/crud', 'CrudController@index');
Route::post('/crud/store', 'CrudController@store');
Route::post('/crud/update', 'CrudController@update');
Route::post('/crud/destroy', 'CrudController@destroy');
