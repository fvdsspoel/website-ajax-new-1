<?php

// BE
Route::group(['middleware' => ['auth']], function () {
	Route::get('/partners/index', 'PartnersController@index');
	Route::get('/partners/create', 'PartnersController@create');
	Route::get('/partners/edit/{id}', 'PartnersController@edit');
	Route::post('/partners/store', 'PartnersController@store');
	Route::post('/partners/delete', 'PartnersController@delete');
});