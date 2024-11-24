<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticlePageController extends Controller
{
    public function show(Request $request, $id)
    {
        $user = Auth::user();
        $username = $user->username ?? 'Guest';
        $article = ArticlePage::with(['tags', 'topic', 'author', 'comments'])->findOrFail($id);
        $referer = $request->headers->get('referer') ?? 'home page';
        $previousPage = $this->getPageNameFromUrl($referer);
        $previousUrl = $referer === 'home page' ? url('/') : $referer;
        $authorDisplayName = $article->author->display_name ?? 'Unknown';
        $trendingTags = Tag::trending()->take(5)->get();
        $recentNews = ArticlePage::getMostRecentNews(3);

        $paragraphs = explode("<?n?n>", $article->content);

        Log::info('Paragraphs: ' . json_encode($paragraphs));

        return view('pages.articlePage', [
            'article' => $article,
            'username' => $username,
            'articleTags' => $article->tags,
            'topic' => $article->topic,
            'comments' => $article->comments,
            'previousPage' => $previousPage,
            'previousUrl' => $previousUrl,
            'authorDisplayName' => $authorDisplayName,
            'trendingTags' => $trendingTags,
            'recentNews' => $recentNews,
            'isHomepage' => false,
            'paragraphs' => $paragraphs
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

        $recentNews = ArticlePage::getAllRecentNews();

        return view('pages.recent_news', [
            'username' => $username,
            'recentNews' => $recentNews
        ]);
    }

    public function showVotedNews()
    {
        $user = Auth::user();
        $username = $user->username ?? 'Guest';

        $votedNews = ArticlePage::getArticlesByVotes();

        return view('pages.voted_news', [
            'username' => $username,
            'votedNews' => $votedNews
        ]);
    }
}
