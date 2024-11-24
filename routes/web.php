<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ArticlePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CreateArticleController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserFollowingTagsController;
use App\Http\Controllers\UserFollowingTopicsController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [HomepageController::class, 'show'])->name('homepage');

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout')->middleware('auth');
});
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Main Dynamic
Route::get('/search', [SearchController::class, 'show'])->name('search.show');
Route::get('/following-tags', [UserFollowingTagsController::class, 'show'])->name('followingTags');
Route::get('/following-topics', [UserFollowingTopicsController::class, 'show'])->name('followingTopics');

// Profile
Route::prefix('profile')->controller
(ProfileController::class)->group(function () {
    Route::get('/user/{username}', 'show')->name('profile');
    Route::get('/edit', 'edit')->name('profile.edit');
    Route::post('/edit', 'update')->name('profile.update');
});
Route::get('/create-article', [CreateArticleController::class, 'create'])->name('createArticle');
Route::post('/submit-article', [CreateArticleController::class, 'store'])->name('submitArticle');

// Article
Route::get('/article/{id}', [ArticlePageController::class, 'show'])->name('article.show');
Route::get('/recent-news', [ArticlePageController::class, 'showRecentNews'])->name('recentnews.show');
Route::get('/voted-news', [ArticlePageController::class, 'showVotedNews'])->name('votednews.show');

// Static Pages
Route::get('/contacts', [ContactsController::class, 'show'])->name('contacts');
Route::get('/about-us', [AboutUsController::class, 'show'])->name('aboutus');
