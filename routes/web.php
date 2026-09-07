<?php

use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/products', [PageController::class, 'products'])->name('products');
Route::get('/showrooms', [PageController::class, 'showrooms'])->name('showrooms');

Route::get('/build-your-own', [ConfiguratorController::class, 'show'])->name('configurator');
Route::post('/build-your-own/price', [ConfiguratorController::class, 'price'])->name('configurator.price');
Route::post('/build-your-own/submit', [ConfiguratorController::class, 'submit'])->name('configurator.submit');

Route::get('/get-a-quote', [QuoteController::class, 'create'])->name('quote.create');
Route::post('/get-a-quote', [QuoteController::class, 'store'])->name('quote.store');

// Admin login intentionally lives off the public nav (report Section 2).
// Point this at whatever admin panel package/route the eventual
// backend uses — kept as a placeholder here.
// Route::get('/admin/login', ...)->name('admin.login');
