<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\HighlightController as AdminHighlightController;
use App\Http\Controllers\Admin\JoinController as AdminJoinController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ShowroomController as AdminShowroomController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\TextController as AdminTextController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/what-we-make', [PageController::class, 'furniture'])->name('furniture');
Route::get('/projects', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/our-colours', [PageController::class, 'colours'])->name('colours');
Route::get('/our-factory', [PageController::class, 'factory'])->name('factory');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/showroom', [PageController::class, 'showrooms'])->name('showrooms');

// Design selector + upload your plan → CRM inquiry (with files).
Route::get('/design-your-space', [DesignController::class, 'show'])->name('design');
Route::post('/design-your-space', [DesignController::class, 'submit'])->middleware('throttle:8,1')->name('design.submit');

Route::get('/contact', [QuoteController::class, 'create'])->name('quote.create');
Route::post('/contact', [QuoteController::class, 'store'])->middleware('throttle:8,1')->name('quote.store');

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

// Old URLs (old live site and the September test build) → new pages (301),
// so Google rankings and links already shared on Facebook keep working.
Route::permanentRedirect('/portfolios', '/projects');
Route::permanentRedirect('/portfolios/view/{any}/{name?}', '/projects');
Route::permanentRedirect('/portfolio', '/projects');
Route::permanentRedirect('/machines', '/our-factory');
Route::permanentRedirect('/show-rooms', '/showroom');
Route::permanentRedirect('/showrooms', '/showroom');
Route::permanentRedirect('/products', '/what-we-make');
Route::permanentRedirect('/products/list', '/what-we-make');
Route::permanentRedirect('/products/list/{any}', '/what-we-make');
Route::permanentRedirect('/accessories', '/what-we-make');
Route::permanentRedirect('/build-your-own', '/design-your-space');
Route::permanentRedirect('/inquiries', '/contact');
Route::permanentRedirect('/contact-us', '/contact');
Route::permanentRedirect('/get-a-quote', '/contact');

// Admin login intentionally lives off the public nav — no link to it
// anywhere in the site's visible UI.
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware(['guest', 'throttle:8,1']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

    // A new person joins with the one-time code an owner gave them (21 November 2026).
    Route::get('/join', [AdminJoinController::class, 'show'])->name('join')->middleware('guest');
    Route::post('/join', [AdminJoinController::class, 'store'])->middleware(['guest', 'throttle:6,1']);

    Route::middleware('auth')->group(function () {
        Route::redirect('/', '/admin/texts');
        Route::get('/texts', [AdminTextController::class, 'index'])->name('texts.index');
        Route::post('/texts', [AdminTextController::class, 'update'])->name('texts.update');
        Route::middleware('can:owner')->prefix('team')->name('team.')->group(function () {
            Route::get('/', [AdminTeamController::class, 'index'])->name('index');
            Route::post('/invite', [AdminTeamController::class, 'invite'])->name('invite');
            Route::delete('/invite/{invite}', [AdminTeamController::class, 'cancel'])->name('cancel');
            Route::patch('/user/{user}', [AdminTeamController::class, 'role'])->name('role');
            Route::delete('/user/{user}', [AdminTeamController::class, 'remove'])->name('remove');
        });
        Route::resource('portfolio', AdminPortfolioController::class)->except('show');
        Route::resource('products', AdminProductController::class)->except('show');
        Route::resource('showrooms', AdminShowroomController::class)->except('show');
        Route::resource('highlights', AdminHighlightController::class)->except('show');
    });
});
