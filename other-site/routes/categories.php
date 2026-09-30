<?php

//BE
Route::group(['middleware' => ['auth']], function () {
	Route::get('/categories', 'CategoriesController@index');
	Route::get('/categories/create', 'CategoriesController@create');
	Route::get('/categories/edit/{id}', 'CategoriesController@edit');
	Route::post('/categories/store', 'CategoriesController@store');
	Route::post('/categories/delete', 'CategoriesController@delete');
});

Route::post('/categories/get-subcategory', 'CategoriesController@getSubCategory');