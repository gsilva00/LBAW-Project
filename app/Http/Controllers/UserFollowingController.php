<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class UserFollowingController extends Controller
{
    public function followTags(Request $request)
    {
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

        return view('pages.display_articles', ['articles' => $articles_followed_tags, 'user' => $user]);
    }

    public function followTopics(Request $request)
    {
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

        return view('pages.followedtopics', ['articles' => $articles_followed_topics, 'user' => $user]);
    }

    public function followAuthors(Request $request)
    {
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

        return view('pages.display_articles', ['articles' => $articles, 'user' => $user]);
    }

    public function showUserFeed(Request $request)
    {
        $user = Auth::user();

        if (Auth::guest() || !Auth::user()->can('viewUserFeed', $user)) {
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
}
