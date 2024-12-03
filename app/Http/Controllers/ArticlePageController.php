<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\ArticlePage;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticlePageController extends Controller
{
    public function show(Request $request, $id): View
    {
        $article = ArticlePage::with(['tags', 'topic', 'author', 'comments', 'comments.replies'])->findOrFail($id);

        $this->authorize('view', $article);

        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();

        $referer = $request->headers->get('referer') ?? 'home page';
        $previousPage = $this->getPageNameFromUrl($referer);
        $previousUrl = $referer === 'home page' ? url('/') : $referer;

        $authorDisplayName = $article->author->display_name ?? 'Unknown';
        $trendingTags = Tag::trending()->take(5)->get();
        $recentNews = ArticlePage::getMostRecentNews(3);

        $paragraphs = explode("<?n?n>", $article->content);
        $voteArticle = $user ? $user->getVoteTypeOnArticle($article) : 0;

        $favourite = $user ? $user->isFavouriteArticle($article) : false;

        /*Log::info('Paragraphs: ' . json_encode($paragraphs));*/

        return view('pages.article_page', [
            'user' => $user,
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
            'voteArticle' => $voteArticle,
            'favourite' => $favourite
        ]);
    }

    private function getPageNameFromUrl(string $url): bool|string
    {
        if ($url === 'home page') {
            return $url;
        }

        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'] ?? '';
        $segments = explode('/', trim($path, '/'));
        return end($segments) ?: 'home page';
    }

    public function showRecentNews(): View
    {
        $this->authorize('viewAny', ArticlePage::class);

        /** @var User $user */
        $user = Auth::user();
        $username = $user->username ?? 'Guest';

        $recentNews = ArticlePage::getAllRecentNews();
        return view('pages.recent_news', [
            'user' => $user,
            'username' => $username,
            'recentNews' => $recentNews
        ]);
    }

    public function showMostVotedNews(): View
    {
        $this->authorize('viewAny', ArticlePage::class);

        $votedNews = ArticlePage::getArticlesByVotes();

        return view('pages.voted_news', [
            'user' => Auth::user(),
            'votedNews' => $votedNews
        ]);
    }

    public function showFavouriteArticles(): View
    {
        $this->authorize('viewAny', ArticlePage::class);

        /** @var User $user */
        $user = Auth::user();
        $favArticles = $user->favouriteArticles;

        return view('pages.favourite_articles', [
            'user' => $user,
            'favArticles' => $favArticles
        ]);
    }

    public function upvote(Request $request, $id): JsonResponse
    {
        Log::info('Upvote request: ' . json_encode($request->all()));

        /** @var User $user */
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        // TODO SPECIAL FEEDBACK WHEN ARTICLE IS DELETED (NO INTERACTIONS ALLOWED)

        $this->authorize('upvote', $article); // TODO REDIRECT TO LOGIN

        $vote = $user->votedArticles()->where('article_id', $id)->first();
        $voteStatus = 0;

        if ($vote) {
            if ($vote->pivot->type === 'Upvote') {
                $user->votedArticles()->detach($id);
                $article->upvotes -= 1;
                $voteStatus = 0;
            }
            else {
                $vote->pivot->type = 'Upvote';
                $vote->pivot->save();
                $article->upvotes += 1;
                $article->downvotes -= 1;
                $voteStatus = 1;
            }
        }
        else {
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

    public function downvote(Request $request, $id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        // TODO SPECIAL FEEDBACK WHEN ARTICLE IS DELETED (NO INTERACTIONS ALLOWED)

        $this->authorize('downvote', ArticlePage::class); // TODO REDIRECT TO LOGIN

        $vote = $user->votedArticles()->where('article_id', $id)->first();
        $voteStatus = 0;

        if ($vote) {
            if ($vote->pivot->type === 'Downvote') {
                $user->votedArticles()->detach($id);
                $article->downvotes -= 1;
                $voteStatus = 0;
            }
            else {
                $vote->pivot->type = 'Downvote';
                $vote->pivot->save();
                $article->downvotes += 1;
                $article->upvotes -= 1;
                $voteStatus = -1;
            }
        }
        else {
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

    public function favourite(Request $request, $id): JsonResponse
    {
        // TODO SPECIAL FEEDBACK WHEN ARTICLE IS DELETED (NO INTERACTIONS ALLOWED)

        $this->authorize('favourite', ArticlePage::class); // TODO REDIRECT TO LOGIN

        /** @var User $user */
        $user = Auth::user();
        $isFavourite = $request->input('isFavourite');

        Log::info("Saved");

        if ($isFavourite) {
            $user->favouriteArticles()->detach($id);
            $favouriteStatus = 0;
        }
        else {
            Log::info("Entrei");
            $user->favouriteArticles()->attach($id);
            $favouriteStatus = 1;
        }

        return response()->json([
            'favouriteStatus' => $favouriteStatus
        ]);
    }

    public function writeComment(Request $request, $id): JsonResponse
    {
        Log::info('Comment request: ' . json_encode($request->all()));

        $this->authorize('create', Comment::class);

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $article = ArticlePage::findOrFail($id);

        $comment = new Comment();
        $comment->author_id = auth()->id();
        $comment->article_id = $article->id;
        $comment->content = $request->comment;
        $comment->save();

        $comments = $article->comments()->with('replies')->get();

        $commentsView = view('partials.comments', compact('comments', 'user', 'article'))->render();

        return response()->json([
            'commentsView' => $commentsView,
        ]);
    }
}


