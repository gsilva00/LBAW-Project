<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\User;
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

        /*Log::info('UserFollowingController@followTags', [
            'tags' => $tags,
            'articles' => $articles_followed_tags,
        ]);*/

        if ($request->ajax()) {
            /*Log::info("AJAX request");*/

            return view('partials.articles_list', ['articles' => $articles_followed_tags]);
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

        /*Log::info('UserFollowingController@followTopics', [
            'tags' => $topics,
            'articles' => $articles_followed_topics,
        ]);*/

        if ($request->ajax()) {
            /*Log::info("AJAX request");*/

            return view('partials.articles_list', ['articles' => $articles_followed_topics]);
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

        $authors = $user->followers()->get();
        $articles = User::filterByFollowingUsers($authors);

        /*Log::info('UserFollowingController@followAuthors', [
            'authors' => $authors,
            'articles' => $articles,
        ]);*/

        if ($request->ajax()) {
            /*Log::info("AJAX request");*/

            return view('partials.articles_list', ['articles' => $articles]);
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

        if (Auth::guest() || $user->cant('viewUserFeed', $user)) {
            return redirect()->route('login')->with('error', 'Unauthorized. You do not possess the valid credentials to access that page.');
        }


        if ($request->ajax()) {
            /*Log::info("AJAX request");*/
            $articles = ArticlePage::all();

            return view('partials.articles_list', ['articles' => $articles]);
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

        Log::info('UserFollowingController@followUser', [
            'user' => $user,
            'request' => $request->input(),
        ]);

        //$this->authorize('followUser', $user);
        Log::info('Test ' . ($user->isFollowingUser($request->profile_id) ? 'true' : 'false'));

        $user->following()->attach($request->profile_id);

        return response()->json(['success' => true]);
    }

    public function unfollowUser(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        //$this->authorize('unfollowUser', $user);

        Log::info('Test ' . ($user->isFollowingUser($request->profile_id) ? 'true' : 'false'));

        $user->following()->detach($request->profile_id);

        return response()->json(['success' => true]);
    }
}
