<?php

// BE
Route::group(['middleware' => ['auth']], function () {
	Route::get('/appointments/index', 'AppointmentsController@index');
	Route::get('/appointments/view/{id}', 'AppointmentsController@view');
});