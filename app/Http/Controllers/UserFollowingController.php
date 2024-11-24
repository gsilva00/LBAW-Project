<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserFollowingController extends Controller
{
    public function followTags()
    {
        $user = Auth::user();
        $this->authorize('viewFollowingTags', $user);

        $tags = $user->followedTags()->get();
        $articles = ArticlePage::all();
        $articles_followed_tags = ArticlePage::filterByTags($articles, $tags);

        return view('pages.display_articles', ['user' => $user, 'articles' => $articles_followed_tags]);
    }

    public function followTopics()
    {
        $user = Auth::user();
        $this->authorize('viewFollowingTopics', $user);

        $tags = $user->followedTopics()->get();
        $articles = ArticlePage::all();
        $articles_followed_tags = ArticlePage::filterByTopics($articles, $tags);

        return view('pages.display_articles', ['user' => $user, 'articles' => $articles_followed_tags]);
    }

    public function followAuthors()
    {
        $user = Auth::user();
        $this->authorize('viewFollowingAuthors', $user);

        $authors = $user->followers()->get();
        $articles = User::filterByFollowingUsers($authors);

        return view('pages.display_articles', ['user' => $user, 'articles' => $articles]);
    }

}
