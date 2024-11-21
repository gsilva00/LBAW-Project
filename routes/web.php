<?php

use App\Http\Controllers\AboutusController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ArticlePageController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::get('/', [HomepageController::class, 'show']);

// Cards
Route::controller(CardController::class)->group(function () {
    Route::get('/cards', 'list')->name('cards');
    Route::get('/cards/{id}', 'show');
});

// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::get('/homepage', [HomepageController::class, 'show'])->name('homepage');

Route::get('/contacts', [ContactsController::class, 'show'])->name('contacts');

Route::get('/article/{id}', [ArticlePageController::class, 'show'])->name('article.show');

// Edit profile
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile/edit', 'edit')->name('profile.edit');
    Route::post('/profile/edit', 'update')->name('profile.update');
});

Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile');

Route::get('/search', [SearchController::class, 'show'])->name('search.show');

Route::get('/recent-news', [ArticlePageController::class, 'showRecentNews'])->name('recentnews.show');

Route::get('/voted-news', [ArticlePageController::class, 'showVotedNews'])->name('votednews.show');

Route::get('/about-us', [AboutusController::class, 'show'])->name('aboutus');