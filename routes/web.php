<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\HighlightController as AdminHighlightController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ShowroomController as AdminShowroomController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/machines', [PageController::class, 'machines'])->name('machines');
Route::get('/accessories', [PageController::class, 'products'])->name('products');
Route::get('/showrooms', [PageController::class, 'showrooms'])->name('showrooms');

Route::get('/build-your-own', [ConfiguratorController::class, 'show'])->name('configurator');
Route::post('/build-your-own/submit', [ConfiguratorController::class, 'submit'])->name('configurator.submit');

Route::get('/get-a-quote', [QuoteController::class, 'create'])->name('quote.create');
Route::post('/get-a-quote', [QuoteController::class, 'store'])->name('quote.store');

// Live chat window → Maya in the CRM (see ChatController).
Route::post('/chat/send', [ChatController::class, 'send'])->middleware('throttle:20,1')->name('chat.send');
Route::get('/chat/poll', [ChatController::class, 'poll'])->middleware('throttle:60,1')->name('chat.poll');

// EN / TL toggle — stores the choice and returns the visitor to the same page.
Route::get('/lang/{locale}', function (Request $request, string $locale) {
    if (array_key_exists($locale, config('company.locales'))) {
        $request->session()->put('locale', $locale);
    }
    return redirect()->back(fallback: route('home'));
})->name('lang.switch');

// Old live-site URLs → new pages (301), so Google rankings and links
// already shared on Facebook keep working after the switch.
Route::permanentRedirect('/portfolios', '/portfolio');
Route::permanentRedirect('/show-rooms', '/showrooms');
Route::permanentRedirect('/products', '/accessories');
Route::permanentRedirect('/products/list', '/accessories');
Route::permanentRedirect('/products/list/{any}', '/accessories');
Route::permanentRedirect('/inquiries', '/get-a-quote');
Route::permanentRedirect('/contact-us', '/get-a-quote');

// Admin login intentionally lives off the public nav — no link to it
// anywhere in the site's visible UI.
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
