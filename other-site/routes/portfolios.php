<?php

// BE
Route::group(['middleware' => ['auth']], function () {
	Route::get('/portfolios/index', 'PortfoliosController@index');
	Route::get('/portfolios/create', 'PortfoliosController@create');
	Route::get('/portfolios/edit/{id}', 'PortfoliosController@edit');
	Route::post('/portfolios/store', 'PortfoliosController@store');
	Route::post('/portfolios/delete', 'PortfoliosController@delete');
});