<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class UserFollowingController extends Controller
{
    public function showFollowingTags(Request $request): View
    {
        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();

        $this->authorize('viewFollowingTags', $user);

        $tags = $user->followedTags()->get();
        $articles = ArticlePage::all();
        $articles_followed_tags = ArticlePage::filterByTags($articles, $tags);

        if ($request->ajax()) {
            return view('partials.articles_list', [
                'articles' => $articles_followed_tags
            ]);
        }

        return view('pages.display_articles', [
            'user' => $user,
            'articles' => $articles_followed_tags
        ]);
    }

    public function showFollowingTopics(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();

        $this->authorize('viewFollowingTopics', $user);

        $topics = $user->followedTopics()->get();
        $articles = ArticlePage::all();
        $articles_followed_topics = ArticlePage::filterByTopics($articles, $topics);

        if ($request->ajax()) {
            return view('partials.articles_list', [
                'articles' => $articles_followed_topics
            ]);
        }

        return view('pages.followedtopics', [
            'user' => $user,
            'articles' => $articles_followed_topics
        ]);
    }

    public function showFollowingAuthors(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();

        $this->authorize('viewFollowingAuthors', $user);

        $authors = $user->following()->where('is_deleted', false)->where('is_banned', false)->get();
        $articles = User::filterByFollowingUsers($authors);

        if ($request->ajax()) {
            return view('partials.articles_list', [
                'articles' => $articles
            ]);
        }

        return view('pages.display_articles', [
            'user' => $user,
            'articles' => $articles
        ]);
    }

    public function showUserFeed(Request $request): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            $this->authorize('viewUserFeed', $user);
        }
        catch (AuthorizationException $e) {
            return redirect()->route('login')
                ->withErrors('Unauthorized. You need to login to access that page.');
        }


        if ($request->ajax()) {
            $articles = ArticlePage::all();

            return view('partials.articles_list', [
                'articles' => $articles
            ]);
        }

        return view('pages.user_feed', [
            'user' => $user,
            'articles' => []
        ]);
    }

    public function followUser(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $targetUser = User::findorFail($request->user_id);

        try {
            $this->authorize('followUser', $targetUser);
        }
        catch (AuthorizationException $e) {
            return redirect()->route('login')
                ->withErrors('Unauthorized. You need to login to perform that action.');
        }

        $user->following()->attach($request->user_id);

        $ownedArticles = $targetUser->ownedArticles()->get();
        $ownedArticles = ArticlePage::filterDeletedArticles($ownedArticles);

        return view('pages.profile', [
            'user' => $user,
            'profileUser' => $targetUser,
            'isAdmin' => $user ? $user->is_admin : false,
            'ownedArticles' => $ownedArticles
        ]);
    }

    public function unfollowUser(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $targetUser = User::findorFail($request->user_id);

        try {
            $this->authorize('unfollowUser', $targetUser);
        } catch (AuthorizationException $e) {
            return redirect()->route('login')
                ->withErrors('Unauthorized. You need to login to perform that action.');
        }

        $user->following()->detach($request->user_id);

        $ownedArticles = $targetUser->ownedArticles()->get();
        $ownedArticles = ArticlePage::filterDeletedArticles($ownedArticles);

        return view('pages.profile', [
            'user' => $user,
            'profileUser' => $targetUser,
            'isAdmin' => $user ? $user->is_admin : false,
            'ownedArticles' => $ownedArticles
        ]);
    }
}
