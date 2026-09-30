<?php

//BE
Route::group(['middleware' => ['auth']], function () {
	Route::get('/size-prices/index', 'SizePricesController@index');
	Route::post('/size-prices/store', 'SizePricesController@store');
});
Route::get('/size-prices/get-data', 'SizePricesController@getData');
Route::post('/size-prices/check', 'SizePricesController@checkData');