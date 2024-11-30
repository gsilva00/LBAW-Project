<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Topic;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticlePageController extends Controller
{
    public function show(Request $request, $id)
    {
        $article = ArticlePage::with(['tags', 'topic', 'author', 'comments', 'comments.replies'])->findOrFail($id);

        $this->authorize('view', $article);

        $user = Auth::user();

        $referer = $request->headers->get('referer') ?? 'home page';
        $previousPage = $this->getPageNameFromUrl($referer);
        $previousUrl = $referer === 'home page' ? url('/') : $referer;

        $authorDisplayName = $article->author->display_name ?? 'Unknown';
        $trendingTags = Tag::trending()->take(5)->get();
        $recentNews = ArticlePage::getMostRecentNews(3);

        $paragraphs = explode("<?n?n>", $article->content);
        $voteArticle = $user ? $user->getVoteTypeOnArticle($article) : 0;

        $favourite = $user->isFavouriteArticle($article);

        Log::info('Vote Article: ' . json_encode($voteArticle));

        /*Log::info('Paragraphs: ' . json_encode($paragraphs));*/

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
            'user' => $user,
            'voteArticle' => $voteArticle,
            'favourite' => $favourite
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

    public function showTrendingTags()
    {
        $user = Auth::user();
        $trendingTags = Tag::where('is_trending', true)
        ->withCount(['articles' => function ($query) {
            $query->where('is_deleted', false);
        }])
        ->get();

        $this->authorize('viewAny', ArticlePage::class);

        $trendingTagsNewsCount = $trendingTags->sum('articles_count');

        return view('pages.trending_tags', [
            'trendingTags' => $trendingTags,
            'trendingTagsNewsCount' => $trendingTagsNewsCount,
            'user' => $user
        ]);
    }

    public function showSavedArticles()
    {
        $user = Auth::user();
        $savedArticles = $user->favouriteArticles;

        return view('pages.saved_articles', [
            'savedArticles' => $savedArticles,
            'user' => $user
        ]);
    }

    public function upvote(Request $request, $id)
    {
        Log::info('Upvote request: ' . json_encode($request->all()));
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $vote = $user->votedArticles()->where('article_id', $id)->first();
        $voteStatus = 0;

        if ($vote) {
            if ($vote->pivot->type === 'Upvote') {
                $user->votedArticles()->detach($id);
                $article->upvotes -= 1;
                $voteStatus = 0;
            } else {
                $vote->pivot->type = 'Upvote';
                $vote->pivot->save();
                $article->upvotes += 1;
                $article->downvotes -= 1;
                $voteStatus = 1;
            }
        } else {
            $user->votedArticles()->attach($id, ['type' => 'Upvote']);
            $article->upvotes += 1;
            $voteStatus = 1;
        }

        $article->save();

        return response()->json([
            'article' => $article,
            'voteStatus' => $voteStatus
        ]);
    }

    public function downvote(Request $request, $id)
    {
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $vote = $user->votedArticles()->where('article_id', $id)->first();
        $voteStatus = 0;

        if ($vote) {
            if ($vote->pivot->type === 'Downvote') {
                $user->votedArticles()->detach($id);
                $article->downvotes -= 1;
                $voteStatus = 0;
            } else {
                $vote->pivot->type = 'Downvote';
                $vote->pivot->save();
                $article->downvotes += 1;
                $article->upvotes -= 1;
                $voteStatus = -1;
            }
        } else {
            $user->votedArticles()->attach($id, ['type' => 'Downvote']);
            $article->downvotes += 1;
            $voteStatus = -1;
        }

        $article->save();

        return response()->json([
            'article' => $article,
            'voteStatus' => $voteStatus
        ]);
    }

    public function favourite(Request $request, $id)
    {
        $user = Auth::user();
        $isFavourite = $request->input('isFavourite');

        Log::info("Saved");

        if ($isFavourite) {
            $user->favouriteArticles()->detach($id);
            $favouriteStatus = 0;
        } else {
            Log::info("Entrei");
            $user->favouriteArticles()->attach($id);
            $favouriteStatus = 1;
        }

        return response()->json([
            'favouriteStatus' => $favouriteStatus
        ]);
    }

}
