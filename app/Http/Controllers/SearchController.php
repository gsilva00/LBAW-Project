<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        $authUser = Auth::user();
        $searchQuery = $this->sanitizeSearchQuery(trim($request->input('search')));
        $tagNames = $request->input('tags', []);
        $topicNames = $request->input('topics', []);

        $tags = Tag::whereIn('name', $tagNames)->get();
        $topics = Topic::whereIn('name', $topicNames)->get();

        $articles = ArticlePage::filterBySearchQuery($searchQuery);

        Log::info('Search tags and topics', [
            'tags' => $tags->pluck('name')->toArray(),
            'topics' => $topics->pluck('name')->toArray()
        ]);

        if($tags->isNotEmpty()) {
            $articles = $this->filters_tag($articles, $tags);
        }


        if($topics->isNotEmpty()) {
            $articles = $this->filters_topic($articles, $topics);
        }


        return view('pages.search', [
            'searchQuery' => $searchQuery,
            'username' => $authUser->username ?? 'Guest',
            'articleItems' => $articles,
            'tags' => $tags,
            'topics' => $topics,
        ]);
    }
    private function sanitizeSearchQuery($query)
    {
        return preg_replace('/[^\w\s"]/', '', $query);
    }

    private function filters_querry($searchQuery)
    {
        if (empty($searchQuery)) {
            $articles = ArticlePage::all();
        } elseif (preg_match('/^".*"$/', $searchQuery)) {
            // Remove the double quotes
            $exactQuery = trim($searchQuery, '"');
            $articles = ArticlePage::where('title', 'ILIKE', '%' . $exactQuery . '%')
                ->orWhere('subtitle', 'ILIKE', '%' . $exactQuery . '%')
                ->orWhere('content', 'ILIKE', '%' . $exactQuery . '%')
                ->get();
        } else {
            $words = explode(' ', $searchQuery);
            $sanitizedWords = array_map(function($word) {
                return $word . ':*';
            }, $words);
            $tsQuery = implode(' & ', $sanitizedWords);

            $articles = ArticlePage::whereRaw("tsv @@ to_tsquery('english', ?)", [$tsQuery])
                ->orWhere(function($query) use ($words) {
                    foreach ($words as $word) {
                        $query->orWhere('title', 'ILIKE', '%' . $word . '%')
                            ->orWhere('subtitle', 'ILIKE', '%' . $word . '%')
                            ->orWhere('content', 'ILIKE', '%' . $word . '%');
                    }
                })
                ->orderByRaw("ts_rank(tsv, to_tsquery('english', ?)) DESC", [$tsQuery])
                ->get();
        }
        return $articles;
    }

    private function filters_tag($articles, $tags)
    {
        return $articles->filter(function($article) use ($tags) {
            return $article->tags->pluck('id')->intersect($tags->pluck('id'))->isNotEmpty();
        });
    }

    private function filters_topic($articles, $topics)
    {
        return $articles->filter(function($article) use ($topics) {
            return $topics->pluck('id')->contains($article->topic->id);
        });
    }

}