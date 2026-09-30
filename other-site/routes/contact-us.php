<?php

Route::get('/contact-us', 'ContactUsController@contactUs');
Route::get('/corporate-inquiry', 'ContactUsController@corporateInquiry');
Route::post('/contact-us/inquiry/store', 'ContactUsController@store');

Route::get('/inquries', 'ContactUsController@index');