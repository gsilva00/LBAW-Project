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

// Main Dynamic Pages
Route::get('/search', [SearchController::class, 'show'])->name('search');

Route::get('/user-feed', [UserFollowingController::class, 'showUserFeed'])->name('userFeed');

Route::get('/recent-news', [ArticlePageController::class, 'showRecentNews'])->name('showRecentNews');
Route::get('/most-voted', [ArticlePageController::class, 'showMostVotedNews'])->name('showMostVotedNews');

Route::get('/trending-tags', [TagController::class, 'showTrendingTags'])->name('showTrendingTags');
Route::get('/tag/{name}', [TagController::class, 'showTag'])->name('showTag');
Route::get('/topic/{name}', [TopicController::class, 'showTopic'])->name('showTopic');


Route::prefix('following')->controller
(UserFollowingController::class)->group(function () {
    Route::get('/tags','showFollowingTags')->name('showFollowingTags');
    Route::get('/topics','showFollowingTopics')->name('showFollowingTopics');
    Route::get('/authors','showFollowingAuthors')->name('showFollowingAuthors');
});

Route::get('/favourite-articles', [ArticlePageController::class, 'showFavouriteArticles'])->name('showFavouriteArticles');

// Profile
Route::prefix('profile')->controller
(ProfileController::class)->group(function () {
    Route::get('/user/{username}', 'showProfile')->name('profile');
    Route::get('/edit/{username}', 'showEdit')->name('editProfile');
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
Route::prefix('article/{id}')->controller
(ArticlePageController::class)->group(function () {
    Route::get('/', 'show')->name('showArticle');
    Route::post('/upvote-article', 'upvoteArticle')->name('upvoteArticle');
    Route::post('/downvote-article', 'downvoteArticle')->name('downvoteArticle');
    Route::post('/favourite-article', 'favourite')->name('favouriteArticle');
    Route::post('/write-comment', 'writeComment')->name('writeComment');
});

Route::controller(CreateArticleController::class)->group(function () {
    Route::get('/create-article', 'create')->name('createArticle');
    Route::post('/create-article', 'store')->name('submitArticle');
    Route::get('/edit-article/{id}', 'edit')->name('editArticle');
    Route::post('/edit-article/{id}', 'update')->name('updateArticle');
    Route::post('/delete-article/{id}', 'delete')->name('deleteArticle');
});

Route::post('/comment/{id}/upvote-comment', [ArticlePageController::class, 'upvoteComment'])->name('comment.upvoteComment');
Route::post('/comment/{id}/downvote-comment', [ArticlePageController::class, 'downvoteComment'])->name('comment.downvoteComment');
Route::post('/comment/{id}/delete-comment', [ArticlePageController::class, 'deleteComment'])->name('comment.deleteComment');
Route::post('/comment/{id}/edit-comment', [ArticlePageController::class, 'editComment'])->name('comment.editComment');

Route::post('/comment/{id}/commentForm', [ArticlePageController::class, 'showCommentForm'])->name('comment.commentForm');
Route::post('/comment/{id}/reply', [ArticlePageController::class, 'replyComment'])->name('comment.replyComment');


Route::post('/reply/{id}/upvote-reply', [ArticlePageController::class, 'upvoteReply'])->name('comment.upvoteReply');
Route::post('/reply/{id}/downvote-reply', [ArticlePageController::class, 'downvoteReply'])->name('comment.downvoteReply');
Route::post('/reply/{id}/delete-reply', [ArticlePageController::class, 'deleteReply'])->name('comment.deleteReply');

Route::post('/report-article-modal/{id}', [ArticlePageController::class, 'showReportArticleModal'])->name('showReportArticleModal');
Route::post('/report-article-submit/{id}', [ArticlePageController::class, 'reportArticleSubmit'])->name('reportArticleSubmit');

// Tag
Route::post('/tag/{name}/follow', [TagController::class, 'followTag'])->name('followTag');
Route::post('/tag/{name}/unfollow', [TagController::class, 'unfollowTag'])->name('unfollowTag');

// Topic
Route::post('/topic/{topic}/follow', [TopicController::class, 'followTopic'])->name('followTopic');
Route::post('/topic/{topic}/unfollow', [TopicController::class, 'unfollowTopic'])->name('unfollowTopic');

// Static Pages
Route::get('/contacts', [ContactsController::class, 'show'])->name('contacts');
Route::get('/about-us', [AboutUsController::class, 'show'])->name('aboutUs');


