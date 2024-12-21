<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ArticlePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\CreateArticleController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\NotificationsController;
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

//Password Recovery
Route::controller(MailController::class)->group(function () {
    Route::get('/recover-password', 'showRecoverPasswordForm')->name('recoverPasswordForm');
    Route::post('/recover-password', 'sendRecoverPasswordEmail')->name('recoverPasswordAction');
    Route::post('/reset-password-check', 'checkResetPassword')->name('resetPasswordCheck');
    Route::get('/reset-password', 'showResetPasswordForm')->name('resetPasswordForm');
    Route::post('/reset-password', 'resetPassword')->name('resetPasswordAction');
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

    Route::post('/user/action/follow','followUser')->name('followUserAction');
    Route::post('/user/action/unfollow','unfollowUser')->name('unfollowUserAction');
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

Route::get('/notifications', [NotificationsController::class, 'showNotificationsPage'])->name('notifications.show.page');
Route::get('/notifications/new/all', [NotificationsController::class, 'newNotifications'])->name('notifications.show.newNotificationsAll');
Route::get('/notifications/archived/all', [NotificationsController::class, 'archivedNotifications'])->name('notifications.show.archivedNotificationsAll');

Route::get('/notifications/new/upvotes', [NotificationsController::class, 'newNotificationsUpvotes'])->name('notifications.show.newNotificationsUpvotes');
Route::get('/notifications/new/comments', [NotificationsController::class, 'newNotificationsComments'])->name('notifications.show.newNotificationsComments');

Route::get('/notifications/archived/upvotes', [NotificationsController::class, 'archivedNotificationsUpvotes'])->name('notifications.show.archivedNotificationsUpvotes');
Route::get('/notifications/archived/comments', [NotificationsController::class, 'archivedNotificationsComments'])->name('notifications.show.archivedNotificationsComments');

Route::get('/notifications/archiving/{id}', [NotificationsController::class, 'archivingNotification'])->name('notifications.archiving');

// Administrator Panel
Route::prefix('admin-panel')->controller
(AdminPanelController::class)->group(function () {
    Route::get('/', 'show')->name('adminPanel');
    // User management
    Route::get('/more-users', 'moreUsers')->name('moreUsers');
    Route::post('/create-user', 'createFullUser')->name('adminCreateUser');
    // Topic management
    Route::get('/more-topics', 'moreTopics')->name('moreTopics');
    Route::post('/create-topic', 'createTopic')->name('adminCreateTopic');
    // Tag management
    Route::get('/more-tags', 'moreTags')->name('moreTags');
    Route::post('/create-tag', 'createTag')->name('createTag');
    Route::post('/toggle-trending-tag/{id}', 'toggleTrending')->name('toggleTrendingTag');
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

    Route::post('porpose-tag/show', 'porposeNewTagShow')->name('showProposeTag');
    Route::post('/propose-tag/submit', 'porposeNewTag')->name('proposeTagSubmit');
});

Route::post('/comment/{id}/upvote-comment', [ArticlePageController::class, 'upvoteComment'])->name('upvoteComment');
Route::post('/comment/{id}/downvote-comment', [ArticlePageController::class, 'downvoteComment'])->name('downvoteComment');
Route::post('/comment/{id}/delete-comment', [ArticlePageController::class, 'deleteComment'])->name('deleteComment');
Route::post('/comment/{id}/edit-comment', [ArticlePageController::class, 'editComment'])->name('editComment');

Route::post('/comment/{id}/commentForm', [ArticlePageController::class, 'showCommentForm'])->name('showCommentForm');
Route::post('/comment/{id}/reply', [ArticlePageController::class, 'replyComment'])->name('replyComment');

Route::post('/reply/{id}/upvote-reply', [ArticlePageController::class, 'upvoteReply'])->name('upvoteReply');
Route::post('/reply/{id}/downvote-reply', [ArticlePageController::class, 'downvoteReply'])->name('downvoteReply');
Route::post('/reply/{id}/delete-reply', [ArticlePageController::class, 'deleteReply'])->name('deleteReply');

Route::post('/report-article-modal/{id}', [ArticlePageController::class, 'showReportArticleModal'])->name('showReportArticleModal');
Route::post('/report-comment-modal/{id}', [ArticlePageController::class, 'showReportCommentModal'])->name('showReportCommentModal');
Route::post('/report-user-modal/{id}', [ArticlePageController::class, 'showReportUserModal'])->name('showReportUserModal');


Route::post('/report-article-submit/{id}', [ArticlePageController::class, 'reportArticleSubmit'])->name('reportArticleSubmit');
Route::post('/report-comment-submit/{id}', [ArticlePageController::class, 'reportCommentSubmit'])->name('reportCommentSubmit');
Route::post('/report-user-submit/{id}', [ArticlePageController::class, 'reportUserSubmit'])->name('reportUserSubmit');


// Tag
Route::post('/tag/{name}/follow', [TagController::class, 'followTag'])->name('followTag');
Route::post('/tag/{name}/unfollow', [TagController::class, 'unfollowTag'])->name('unfollowTag');

// Topic
Route::post('/topic/{topic}/follow', [TopicController::class, 'followTopic'])->name('followTopic');
Route::post('/topic/{topic}/unfollow', [TopicController::class, 'unfollowTopic'])->name('unfollowTopic');

// Static Pages
Route::get('/features', [FeaturesController::class, 'show'])->name('features');
Route::get('/contacts', [ContactsController::class, 'show'])->name('contacts');
Route::get('/about-us', [AboutUsController::class, 'show'])->name('aboutUs');


