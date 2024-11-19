<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlePageController extends Controller
{
    public function show(Request $request, $id)
    {
        $user = Auth::user();
        $username = $user->username ?? 'Guest';
        $article = ArticlePage::with(['tags', 'topic'])->findOrFail($id);
        $referer = $request->headers->get('referer') ?? 'home page';
        $previousPage = $this->getPageNameFromUrl($referer);
        $previousUrl = $referer === 'home page' ? url('/') : $referer;

        return view('pages.articlePage', [
            'article' => $article,
            'username' => $username,
            'tags' => $article->tags,
            'topic' => $article->topic,
            'previousPage' => $previousPage,
            'previousUrl' => $previousUrl
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
}
