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
Route::post('/build-your-own/submit', [ConfiguratorController::class, 'submit'])->name('configurator.submit');

Route::get('/get-a-quote', [QuoteController::class, 'create'])->name('quote.create');
Route::post('/get-a-quote', [QuoteController::class, 'store'])->name('quote.store');

// Admin login intentionally lives off the public nav (report Section 2) —
// no link to it anywhere in the site's visible UI.
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\HighlightController as AdminHighlightController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ShowroomController as AdminShowroomController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('guest');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::resource('portfolio', AdminPortfolioController::class)->except('show');
        Route::resource('products', AdminProductController::class)->except('show');
        Route::resource('showrooms', AdminShowroomController::class)->except('show');
        Route::resource('highlights', AdminHighlightController::class)->except('show');
    });
});
