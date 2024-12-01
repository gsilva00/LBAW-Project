<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Comment;
use App\Models\Reply;
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

        $favourite = $user ? $user->isFavouriteArticle($article) : false;

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

    public function upvoteArticle($id)
    {
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $vote = $user->votedArticles()->where('article_id', $id)->first();

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

    public function downvoteArticle($id)
    {
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $vote = $user->votedArticles()->where('article_id', $id)->first();

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

    public function writeComment(Request $request, $id)
    {
        Log::info('Comment request: ' . json_encode($request->all()));

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

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

    public function upvoteComment(Request $request, $id)
    {

        Log::info("Id: " . $id);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment = Comment::findOrFail($id);

        $vote = $comment->voters()->where('user_id', $user->id)->first();

        if ($vote) {
            if ($vote->pivot->type === 'Upvote') {
                $comment->voters()->detach($user->id);
                $comment->upvotes--;
                $isUpvoted = false;
            } else {
                $vote->pivot->type = 'Upvote';
                $vote->pivot->save();
                $comment->upvotes++;
                $comment->downvotes--;
                $isUpvoted = true;
            }
        } else {
            $comment->voters()->attach($user->id, ['type' => 'Upvote']);
            $comment->upvotes++;
            $isUpvoted = true;
        }

        $comment->save();

        return response()->json([
            'comment' => $comment,
            'isUpvoted' => $isUpvoted,
        ]);
    }

    public function downvoteComment($id)
    {
        Log::info("Id: " . $id);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment = Comment::findOrFail($id);

        $vote = $comment->voters()->where('user_id', $user->id)->first();

        if ($vote) {
            if ($vote->pivot->type === 'Downvote') {
                $comment->voters()->detach($user->id);
                $comment->downvotes--;
                $isDownvoted = false;
            } else {
                $vote->pivot->type = 'Downvote';
                $vote->pivot->save();
                $comment->downvotes++;
                $comment->upvotes--;
                $isDownvoted = true;
            }
        } else {
            $comment->voters()->attach($user->id, ['type' => 'Downvote']);
            $comment->downvotes++;
            $isDownvoted = true;
        }

        $comment->save();

        return response()->json([
            'comment' => $comment,
            'isDownvoted' => $isDownvoted,
        ]);
    }

    public function upvoteReply($id)
    {
        Log::info("Id: " . $id);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $reply = Reply::findOrFail($id);

        $vote = $reply->voters()->where('user_id', $user->id)->first();

        if ($vote) {
            if ($vote->pivot->type === 'Upvote') {
                $reply->voters()->detach($user->id);
                $reply->upvotes--;
                $isUpvoted = false;
            } else {
                $vote->pivot->type = 'Upvote';
                $vote->pivot->save();
                $reply->upvotes++;
                $reply->downvotes--;
                $isUpvoted = true;
            }
        } else {
            $reply->voters()->attach($user->id, ['type' => 'Upvote']);
            $reply->upvotes++;
            $isUpvoted = true;
        }

        $reply->save();

        return response()->json([
            'reply' => $reply,
            'isUpvoted' => $isUpvoted,
        ]);
    }

    public function downvoteReply($id){
        Log::info("Id: " . $id);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $reply = Reply::findOrFail($id);

        $vote = $reply->voters()->where('user_id', $user->id)->first();

        if ($vote) {
            if ($vote->pivot->type === 'Downvote') {
                $reply->voters()->detach($user->id);
                $reply->downvotes--;
                $isDownvoted = false;
            } else {
                $vote->pivot->type = 'Downvote';
                $vote->pivot->save();
                $reply->downvotes++;
                $reply->upvotes--;
                $isDownvoted = true;
            }
        } else {
            $reply->voters()->attach($user->id, ['type' => 'Downvote']);
            $reply->downvotes++;
            $isDownvoted = true;
        }

        $reply->save();

        return response()->json([
            'reply' => $reply,
            'isDownvoted' => $isDownvoted,
        ]);
    }

}


