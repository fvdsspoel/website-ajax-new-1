<?php

Route::get('/', 'HomesController@index')->name('home');
Route::get('/homes', 'HomesController@index')->name('home');

// DASHBOARD
Route::group(['middleware' => ['auth']], function () {
	Route::get('/home', 'HomesController@dashboard');
	Route::post('/cms', 'HomesController@cmsStore');
});
