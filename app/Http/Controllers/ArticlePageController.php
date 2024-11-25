<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Topic;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticlePageController extends Controller
{
    public function show(Request $request, $id)
    {
        $article = ArticlePage::with(['tags', 'topic', 'author', 'comments'])->findOrFail($id);

        $this->authorize('view', $article);

        $user = Auth::user();

        $referer = $request->headers->get('referer') ?? 'home page';
        $previousPage = $this->getPageNameFromUrl($referer);
        $previousUrl = $referer === 'home page' ? url('/') : $referer;

        $authorDisplayName = $article->author->display_name ?? 'Unknown';
        $trendingTags = Tag::trending()->take(5)->get();
        $recentNews = ArticlePage::getMostRecentNews(3);

        $paragraphs = explode("<?n?n>", $article->content);

        Log::info('Paragraphs: ' . json_encode($paragraphs));

        return view('pages.article_page', [
            'article' => $article,
            'articleTags' => $article->tags,
            'topic' => $article->topic,
            'comments' => $article->comments,
            'previousPage' => $previousPage,
            'previousUrl' => $previousUrl,
            'authorDisplayName' => $authorDisplayName,
            'trendingTags' => $trendingTags,
            'recentNews' => $recentNews,
            'isHomepage' => false,
            'paragraphs' => $paragraphs,
            'user' => $user
        ]);
    }

    private function getPageNameFromUrl($url)
    {
        if ($url === 'home page') {
            return $url;
        }

        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'] ?? '';
        $segments = explode('/', trim($path, '/'));
        return end($segments) ?: 'home page';
    }

    public function showRecentNews()
    {
        $user = Auth::user();
        $username = $user->username ?? 'Guest';

        $this->authorize('viewAny', ArticlePage::class);

        $recentNews = ArticlePage::getAllRecentNews();
        return view('pages.recent_news', [
            'username' => $username,
            'recentNews' => $recentNews,
            'user' => $user
        ]);
    }

    public function showVotedNews()
    {
        $user = Auth::user();

        $this->authorize('viewAny', ArticlePage::class);

        $votedNews = ArticlePage::getArticlesByVotes();
        return view('pages.voted_news', [
            'votedNews' => $votedNews,
            'user' => $user
        ]);
    }

    public function showTopic($name)
    {
        $user = Auth::user();
        $topic = Topic::where('name', $name)->firstOrFail();
        $articles = $topic->articles()->get();
        $this->authorize('viewAny', ArticlePage::class);

        return view('pages.topic_page', [
            'topic' => $topic,
            'articles' => $articles,
            'user' => $user
        ]);
    }

    public function showTag($name)
    {
        $user = Auth::user();
        $tag = Tag::where('name', $name)->firstOrFail();
        $articles = $tag->articles()->get();
        $this->authorize('viewAny', ArticlePage::class);

        return view('pages.tag_page', [
            'tag' => $tag,
            'articles' => $articles,
            'user' => $user
        ]);
    }

    public function showTrendingTagsNews()
    {
        $user = Auth::user();
        $trendingTags = Tag::where('is_trending', true)
        ->withCount(['articles' => function ($query) {
            $query->where('is_deleted', false);
        }])
        ->get();

        $trendingTagsNewsCount = $trendingTags->sum('articles_count');

        return view('pages.trending_tags_news', [
            'trendingTags' => $trendingTags,
            'trendingTagsNewsCount' => $trendingTagsNewsCount,
            'user' => $user
        ]);
    }

}
