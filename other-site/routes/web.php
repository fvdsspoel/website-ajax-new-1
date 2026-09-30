<?php

Auth::routes();
/*LOGIN*/
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

/*Editor*/
Route::post('/upload/image', 'CodeHelpersController@uploadImage');

/*REGISTER*/
Route::get('/register', '\App\Http\Controllers\Auth\LoginController@noaccess');

/*RESET PASSWORD*/
Route::get('/password/reset', '\App\Http\Controllers\Auth\LoginController@noaccess');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/home', 'HomeController@index')->name('home');
