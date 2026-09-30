<?php

// BE
Route::group(['middleware' => ['auth']], function () {
	Route::get('/non-build-products/index', 'NonBuildProductsController@index');
	Route::get('/non-build-products/create', 'NonBuildProductsController@create');
	Route::get('/non-build-products/edit/{id}', 'NonBuildProductsController@edit');
	Route::post('/non-build-products/store', 'NonBuildProductsController@store');
	Route::post('/non-build-products/delete', 'NonBuildProductsController@delete');
	Route::post('/non-build-products/get-sub-products', 'NonBuildProductsController@getSubProducts');
});

Route::get('/non-build-products/{id}', 'NonBuildProductsController@list');
Route::get('/non-build-products/show/{name}/{id}', 'NonBuildProductsController@show');