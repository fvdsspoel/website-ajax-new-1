<?php

//BE
Route::group(['middleware' => ['auth']], function () {
	Route::get('/our-services/index', 'OurServicesController@index');
	Route::get('/our-services/create', 'OurServicesController@create');
	Route::get('/our-services/edit/{id}', 'OurServicesController@edit');
	Route::post('/our-services/store', 'OurServicesController@store');
	Route::post('/our-services/delete', 'OurServicesController@delete');
});