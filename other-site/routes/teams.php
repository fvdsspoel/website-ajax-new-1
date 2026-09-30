<?php

// BE
Route::group(['middleware' => ['auth']], function () {
	Route::get('/teams/index', 'TeamsController@index');
	Route::get('/teams/create', 'TeamsController@create');
	Route::get('/teams/edit/{id}', 'TeamsController@edit');
	Route::post('/teams/store', 'TeamsController@store');
	Route::post('/teams/delete', 'TeamsController@delete');
});