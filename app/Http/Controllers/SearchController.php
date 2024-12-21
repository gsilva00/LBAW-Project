<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function show(Request $request): View
    {
        Log::info('Request', $request->input());

        if($request->input('search-select') === 'article'){
            $result = $this->searchArticle($request);
        }
        else if($request->input('search-select') === 'comment') {
            $result = $this->searchCommentsPrivate($request);
        }
        else{
            $result = $this->searchUsers($request);
        }

        return $result;
    }

    private function searchArticle(Request $request):view
    {
        $authUser = Auth::user();
        $searchQuery = $this->sanitizeSearchQuery(trim($request->input('search')));

        $topicNames = $request->input('topics', []);
        $tagNames = $request->input('tags', []);

        $tags = Tag::whereIn('name', $tagNames)->get();
        $topics = Topic::whereIn('name', $topicNames)->get();

        $articles = ArticlePage::filterBySearchQuery($searchQuery);

        if ($tags->isNotEmpty()) {
            $articles = ArticlePage::filterByTags($articles, $tags);
        }

        if ($topics->isNotEmpty()) {
            $articles = ArticlePage::filterByTopics($articles, $topics);
        }

        return view('pages.search_article', [
            'user' => $authUser,
            'searchQuery' => $searchQuery,
            'articleItems' => $articles,
            'searchedTags' => $tags,
            'searchedTopics' => $topics
        ]);
    }

    private function searchCommentsPrivate(Request $request):view
    {
        $authUser = Auth::user();
        $searchQuery = $this->sanitizeSearchQuery(trim($request->input('search')));

        $comments = Comment::filterBySearchQuery($searchQuery);
        $replies = Reply::filterBySearchQuery($searchQuery);

        return view('pages.search_comments', [
            'user' => $authUser,
            'searchQuery' => $searchQuery,
            'commentsItems' => $comments,
            'repliesItems' => $replies,
        ]);
    }

    private function searchUsers(Request $request):view
    {
        $authUser = Auth::user();
        $searchQuery = $this->sanitizeSearchQuery(trim($request->input('search')));

        $users = User::filterBySearchQuery($searchQuery);
        $users = User::removeBannedAndDeletedUsers($users);

        return view('pages.search_users', [
            'user' => $authUser,
            'searchQuery' => $searchQuery,
            'usersItems' => $users,
        ]);
    }

    private function sanitizeSearchQuery($query): string
    {
        return preg_replace('/[^\w\s"]/', '', $query);
    }

}