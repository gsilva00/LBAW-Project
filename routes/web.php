<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ArticlePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CreateArticleController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserFollowingController;
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
Route::redirect('/', '/homepage');
Route::get('/homepage', [HomepageController::class, 'show'])->name('homepage');

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Main Dynamic
Route::get('/search', [SearchController::class, 'show'])->name('search');

Route::get('/user-feed', [UserFollowingController::class, 'showUserFeed'])->name('userFeed');

Route::prefix('following')->controller
(UserFollowingController::class)->group(function () {
    Route::get('/tags','followTags')->name('followingTags');
    Route::get('/topics','followTopics')->name('followingTopics');
    Route::get('/authors','followAuthors')->name('followingAuthors');
});

// Profile
Route::prefix('profile')->controller
(ProfileController::class)->group(function () {
    Route::get('/user/{username}', 'show')->name('profile');
    Route::get('/edit/{username}', 'edit')->name('editProfile');
    Route::post('/edit/{username}', 'update')->name('updateProfile');
    Route::post('/delete/{id}', 'delete')->name('deleteProfile');
});

// Administrator Panel
Route::prefix('admin-panel')->controller
(AdminPanelController::class)->group(function () {
    Route::get('/', 'show')->name('adminPanel');
    Route::post('/create-user', 'createFullUser')->name('adminCreateUser');
    Route::get('/more-users', 'moreUsers')->name('moreUsers');
});

// Article
Route::controller(CreateArticleController::class)->group(function () {
    Route::get('/create-article', 'create')->name('createArticle');
    Route::post('/create-article', 'store')->name('submitArticle');
    Route::get('/edit-article/{id}', 'edit')->name('editArticle');
    Route::post('/edit-article/{id}', 'update')->name('updateArticle');
    Route::post('/delete-article/{id}', 'delete')->name('deleteArticle');
});

Route::get('/article/{id}', [ArticlePageController::class, 'show'])->name('showArticle');
Route::get('/recent-news', [ArticlePageController::class, 'showRecentNews'])->name('showRecentNews');
Route::get('/most-voted', [ArticlePageController::class, 'showVotedNews'])->name('showVotedNews');
Route::get('/trending-tags', [ArticlePageController::class, 'showTrendingTags'])->name('showTrendingTags');
Route::get('/topic/{name}', [ArticlePageController::class, 'showTopic'])->name('showTopic');
Route::get('/tag/{name}', [ArticlePageController::class, 'showTag'])->name('showTag');
Route::get('/saved-articles', [ArticlePageController::class, 'showSavedArticles'])->name('showSavedArticles');

// Tag
Route::post('/tag/{tag}/follow', [TagController::class, 'followTag'])->name('tag.follow');
Route::post('/tag/{tag}/unfollow', [TagController::class, 'unfollowTag'])->name('tag.unfollow');

// Topic
Route::post('/topic/{topic}/follow', [TopicController::class, 'followTopic'])->name('topic.follow');
Route::post('/topic/{topic}/unfollow', [TopicController::class, 'unfollowTopic'])->name('topic.unfollow');

Route::post('/article/{id}/upvoteArticle', [ArticlePageController::class, 'upvoteArticle'])->name('article.upvoteArticle');
Route::post('/article/{id}/downvoteArticle', [ArticlePageController::class, 'downvoteArticle'])->name('article.downvoteArticle');
Route::post('/article/{id}/favourite', [ArticlePageController::class, 'favourite'])->name('article.favourite');
Route::post('/article/{id}/writecomment', [ArticlePageController::class, 'writeComment'])->name('article.writecomment');

Route::post('/comment/{id}/upvoteComment', [ArticlePageController::class, 'upvoteComment'])->name('comment.upvoteComment');
Route::post('/comment/{id}/downvoteComment', [ArticlePageController::class, 'downvoteComment'])->name('comment.downvoteComment');

Route::post('/reply/{id}/upvoteReply', [ArticlePageController::class, 'upvoteReply'])->name('comment.upvoteReply');
Route::post('/reply/{id}/downvoteReply', [ArticlePageController::class, 'downvoteReply'])->name('comment.downvoteReply');


// Static Pages
Route::get('/contacts', [ContactsController::class, 'show'])->name('contacts');
Route::get('/about-us', [AboutUsController::class, 'show'])->name('aboutUs');
