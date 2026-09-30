<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatsController;

Route::get('/chats/messages/{id}', [ChatsController::class, 'chatMessages']);
Route::post('/chats/store', [ChatsController::class, 'storeMessage']);
Route::post('/chats/message', [ChatsController::class, 'sendMessage']);
Route::get('/chats/show/{id}', [ChatsController::class, 'showMessage']);

Route::group(['middleware' => ['auth']], function () {
	Route::get('/chats/list', [ChatsController::class, 'list']);
});