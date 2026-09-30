<?php

//BE
Route::group(['middleware' => ['auth']], function () {
	Route::get('/products/index', 'ProductsController@index');
	Route::get('/products/create', 'ProductsController@create');

	Route::get('/products/edit/{id}', 'ProductsController@edit');
	Route::post('/products/styles', 'ProductsController@getStyles');
	Route::post('/products/features', 'ProductsController@getFeatures');
	Route::post('/products/feature-details', 'ProductsController@getFeatureDetails');
	Route::post('/products/store', 'ProductsController@store');

	Route::get('/products/setting/{id}', 'ProductsController@setting');
	Route::post('/products/setting/store', 'ProductsController@settingStore');
	Route::post('/products/views', 'ProductsController@getViews');
	Route::post('/products/custom-style-sizes', 'ProductsController@getCustomStyleSizes');
	Route::post('/products/basic-sizes', 'ProductsController@getBasicSizes');
	Route::post('/products/colors', 'ProductsController@getColors');

	Route::post('/products/delete', 'ProductsController@delete');
	Route::post('/products/feature', 'ProductsController@feature');
});

//FE
Route::get('/products', 'ProductsController@products');
Route::get('/products/show/{name}/{id}', 'ProductsController@show');
Route::get('/products/build/{id}', 'ProductsController@build');
Route::post('/products/style-views', 'ProductsController@getStyleViews');
Route::post('/products/style-sizes', 'ProductsController@getStyleSizes');
Route::post('/products/get-setting-detail', 'ProductsController@getSettingDetail');
Route::post('/products/get-product-setting-detail', 'ProductsController@getProductSettingDetail');
Route::post('/products/book-appointment/store', 'ProductsController@appointmentStore');

Route::get('/template', 'ProductsController@template');

Route::get('/product-settings-image/{id}/{syle}/{product_name}/{folder_name}/{sub_folder}', 'ProductsController@productSettingsImage');