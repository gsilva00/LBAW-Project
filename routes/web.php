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

// Password Recovery
Route::controller(MailController::class)->group(function () {
    Route::get('/password/recover', 'showRecoverPasswordForm')->name('recoverPasswordForm');
    Route::post('/password/recover', 'sendRecoverPasswordEmail')->name('recoverPasswordAction');
    Route::post('/password/verification-code/check', 'checkResetPassword')->name('resetPasswordCheck');
    Route::get('/password/reset', 'showResetPasswordForm')->name('resetPasswordForm');
    Route::post('/password/reset', 'resetPassword')->name('resetPasswordAction');
});

// Main Dynamic Pages
Route::controller(SearchController::class)->group(function () {
    Route::get('/search', 'show')->name('search');
});

Route::controller(UserFollowingController::class)->group(function () {
    // User feed
    Route::get('/user-feed', 'showUserFeed')->name('userFeed');
    Route::get('/following/tags', 'showFollowingTags')->name('showFollowingTags');
    Route::get('/following/topics', 'showFollowingTopics')->name('showFollowingTopics');
    Route::get('/following/authors', 'showFollowingAuthors')->name('showFollowingAuthors');
});

Route::controller(ArticlePageController::class)->group(function () {
    Route::get('/recent-news', 'showRecentNews')->name('showRecentNews');
    Route::get('/most-voted', 'showMostVotedNews')->name('showMostVotedNews');
    Route::get('/favourite-articles', 'showFavouriteArticles')->name('showFavouriteArticles');
});



Route::controller(TagController::class)->group(function () {
    Route::get('/trending-tags', 'showTrendingTags')->name('showTrendingTags');
    Route::get('/tag/{name}', 'showTag')->name('showTag');
    // Following
    Route::post('/tag/{name}/follow', 'followTag')->name('followTag');
    Route::post('/tag/{name}/unfollow', 'unfollowTag')->name('unfollowTag');
});

Route::controller(TopicController::class)->group(function () {
    Route::get('/topic/{name}', 'showTopic')->name('showTopic');
    // Following
    Route::post('/topic/{name}/follow', 'followTopic')->name('followTopic');
    Route::post('/topic/{name}/unfollow', 'unfollowTopic')->name('unfollowTopic');
});

// Profile
Route::prefix('profile')->controller(ProfileController::class)->group(function () {
    Route::get('/{username}', 'showProfile')->name('profile');
    Route::get('/{username}/edit', 'showEdit')->name('editProfile');
    Route::post('/{username}/edit', 'update')->name('updateProfile');
    Route::post('/{id}/delete', 'delete')->name('deleteProfile');
    // Following users
    Route::post('/user/follow', 'followUser')->name('followUserAction');
    Route::post('/user/unfollow', 'unfollowUser')->name('unfollowUserAction');
    // Appeals
    Route::post('/appeal-unban', 'appealUnbanShow')->name('appealUnbanShow');
    Route::post('/appeal-unban', 'appealUnbanSubmit')->name('appealUnbanSubmit');
});

// Notifications
Route::prefix('notifications')->controller
(NotificationsController::class)->group(function () {
    Route::get('/', 'showNotificationsPage')->name('showNotificationsPage');
    Route::get('/new/all', 'newNotifications')->name('showNewNotificationsAll');
    Route::get('/new/upvotes', 'newNotificationsUpvotes')->name('showNewNotificationsUpvotes');
    Route::get('/new/comments', 'newNotificationsComments')->name('showNewNotificationsComments');
    Route::get('/archived/all', 'archivedNotifications')->name('showArchivedNotificationsAll');
    Route::get('/archived/upvotes', 'archivedNotificationsUpvotes')->name('showArchivedNotificationsUpvotes');
    Route::get('/archived/comments', 'archivedNotificationsComments')->name('showArchivedNotificationsComments');

    Route::get('/{id}/archive', 'archivingNotification')->name('archiveNotification');
});

// Administrator Panel
Route::prefix('admin-panel')->controller
(AdminPanelController::class)->group(function () {
    Route::get('/', 'show')->name('adminPanel');
    // User management
    Route::get('/users', 'moreUsers')->name('moreUsers');
    Route::post('/users/create', 'createFullUser')->name('adminCreateUser');
    Route::post('/users/{id}/ban', 'banUser')->name('adminBanUser');
    Route::post('/users/{id}/unban', 'unbanUser')->name('adminUnbanUser');
    // Topic management
    Route::get('/topics', 'moreTopics')->name('moreTopics');
    Route::post('/topics/create', 'createTopic')->name('adminCreateTopic');
    // Tag management
    Route::get('/tags', 'moreTags')->name('moreTags');
    Route::post('/tags/create', 'createTag')->name('createTag');
    Route::post('/tags/trending/{id}/toggle', 'toggleTrending')->name('toggleTrendingTag');
    // Tag proposal management
    Route::get('/tag-proposals', 'moreTagProposals')->name('moreTagProposals');
    Route::post('/tag-proposals/{id}/accept', 'acceptTagProposal')->name('acceptTagProposal');
    Route::post('/tag-proposals/{id}/reject', 'rejectTagProposal')->name('rejectTagProposal');
    // Unban appeal management
    Route::get('/unban-appeals', 'moreUnbanAppeals')->name('moreUnbanAppeals');
    Route::post('/unban-appeals/{id}/accept', 'acceptUnbanAppeal')->name('acceptUnbanAppeal');
    Route::post('/unban-appeals/{id}/reject', 'rejectUnbanAppeal')->name('rejectUnbanAppeal');
});

// Article
Route::prefix('article/{id}')->controller
(ArticlePageController::class)->group(function () {
    Route::get('/', 'show')->name('showArticle');
    Route::post('/upvote', 'upvoteArticle')->name('upvoteArticle');
    Route::post('/downvote', 'downvoteArticle')->name('downvoteArticle');
    Route::post('/favourite', 'favourite')->name('favouriteArticle');
    Route::post('/comment/write', 'writeComment')->name('writeComment');
});

Route::controller(CreateArticleController::class)->group(function () {
    Route::get('/article/create', 'create')->name('createArticle');
    Route::post('/article/create', 'store')->name('submitArticle');
    Route::get('/article/{id}/edit', 'edit')->name('editArticle');
    Route::post('/article/{id}/edit', 'update')->name('updateArticle');
    Route::post('/article/{id}/delete', 'delete')->name('deleteArticle');

    Route::post('article/create/tag/propose', 'proposeNewTagShow')->name('showProposeTag');
    Route::post('/article/create/tag/propose', 'proposeNewTag')->name('proposeTagSubmit');
});

// Article Comments
Route::controller(ArticlePageController::class)->group(function () {
    Route::post('/comment/{id}/upvote', 'upvoteComment')->name('upvoteComment');
    Route::post('/comment/{id}/downvote', 'downvoteComment')->name('downvoteComment');
    Route::post('/comment/{id}/delete', 'deleteComment')->name('deleteComment');
    Route::post('/comment/{id}/edit', 'editComment')->name('editComment');

    Route::post('/comment/{id}/form', 'showCommentForm')->name('showCommentForm');
    Route::post('/comment/{id}/reply', 'replyComment')->name('replyComment');

    Route::post('/reply/{id}/upvote', 'upvoteReply')->name('upvoteReply');
    Route::post('/reply/{id}/downvote', 'downvoteReply')->name('downvoteReply');
    Route::post('/reply/{id}/delete', 'deleteReply')->name('deleteReply');

    Route::post('/article/{id}/report-modal', 'showReportArticleModal')->name('showReportArticleModal');
    Route::post('/comment/{id}/report-modal', 'showReportCommentModal')->name('showReportCommentModal');
    Route::post('/user/{id}/report-modal', 'showReportUserModal')->name('showReportUserModal');
    Route::post('/article/{id}/report', 'reportArticleSubmit')->name('reportArticleSubmit');
    Route::post('/comment/{id}/report', 'reportCommentSubmit')->name('reportCommentSubmit');
    Route::post('/user/{id}/report', 'reportUserSubmit')->name('reportUserSubmit');
});

// Static Pages
Route::get('/features', [FeaturesController::class, 'show'])->name('features');
Route::get('/contacts', [ContactsController::class, 'show'])->name('contacts');
Route::get('/about-us', [AboutUsController::class, 'show'])->name('aboutUs');
