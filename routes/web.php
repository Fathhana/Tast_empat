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
	return redirect()->to('/article');
});


Route::post('/article/store', 'ArticleController@store');
Route::post('/article/update', 'ArticleController@update');
Route::post('/article/destroy', 'ArticleController@destroy');
Route::resource('article','ArticleController');

//Import Export Excel,ods,csv MaatWebsite
Route::get('importExport', 'ImportExcel@importExport');
Route::get('downloadExcel/{type}', 'ImportExcel@downloadExcel');
Route::post('importExcel', 'ImportExcel@importExcel');


Auth::routes();

Route::get('/home', 'HomeController@index');
