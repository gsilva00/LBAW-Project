<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function show(Request $request): View
    {
        $authUser = Auth::user();
        $searchQuery = $this->sanitizeSearchQuery(trim($request->input('search')));

        /*Log::info('Search query', [
            'tags' => $request->input('tags', ''),
            'topics' => $request->input('topics', '')
        ]);*/

        $topicNames = $request->input('topics', []);
        $tagNames = $request->input('tags', []);

        $tags = Tag::whereIn('name', $tagNames)->get();
        $topics = Topic::whereIn('name', $topicNames)->get();

        $articles = ArticlePage::filterBySearchQuery($searchQuery);

        /*Log::info('Search tags and topics', [
            'tags' => $tags->pluck('name')->toArray(),
            'topics' => $topics->pluck('name')->toArray()
        ]);*/

        if ($tags->isNotEmpty()) {
            $articles = ArticlePage::filterByTags($articles, $tags);
        }

        if ($topics->isNotEmpty()) {
            $articles = ArticlePage::filterByTopics($articles, $topics);
        }

        return view('pages.search', [
            'user' => $authUser,
            'searchQuery' => $searchQuery,
            'articleItems' => $articles,
            'searchedTags' => $tags,
            'searchedTopics' => $topics
        ]);
    }
    private function sanitizeSearchQuery($query): string
    {
        return preg_replace('/[^\w\s"]/', '', $query);
    }

}