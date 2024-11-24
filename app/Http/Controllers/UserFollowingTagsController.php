<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use Illuminate\Support\Facades\Auth;

class UserFollowingTagsController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $this->authorize('viewFollowingTags', $user);

        $tags = $user->followedTags()->get();
        $articles = ArticlePage::all();
        $articles_followed_tags = ArticlePage::filterByTags($articles, $tags);

        return view('pages.display_articles', ['user' => $user, 'articles' => $articles_followed_tags]);
    }
}
