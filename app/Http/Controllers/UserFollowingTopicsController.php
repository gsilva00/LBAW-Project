<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFollowingTopicsController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $this->authorize('viewFollowingTopics', $user);

        $tags = $user->followedTopics()->get();
        $articles = ArticlePage::all();
        $articles_followed_tags = ArticlePage::filterByTopics($articles, $tags);

        return view('pages.displayArticles', ['user' => $user, 'articles' => $articles_followed_tags]);
    }
}
