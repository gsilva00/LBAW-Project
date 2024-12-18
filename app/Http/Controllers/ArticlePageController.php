<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Report;
use App\Models\ReportArticle;
use App\Models\ReportComment;
use App\Models\ReportUser;
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

    public function upvoteArticle($id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('upvote', $article);

        $vote = $user->votedArticles()->where('article_id', $id)->first();

        if ($vote) {
            if ($vote->pivot->type === 'Upvote') {
                $user->votedArticles()->detach($id);
                $article->upvotes -= 1;
                $voteStatus = 0;
            } else {
                $article->voteArticleTransaction($user->id, $id, 'Upvote', $article->author_id, $user->id, now());
                $article->downvotes -= 1;
                $voteStatus = 1;
            }
        } else {
            $article->voteArticleTransaction($user->id, $id, 'Upvote', $article->author_id, $user->id, now());
            $voteStatus = 1;
        }

        $article->save();

        $article->refresh();

        return response()->json([
            'article' => $article,
            'voteStatus' => $voteStatus
        ]);
    }

    public function downvoteArticle($id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('downvote', $article);

        $vote = $user->votedArticles()->where('article_id', $id)->first();

        if ($vote) {
            if ($vote->pivot->type === 'Downvote') {
                $user->votedArticles()->detach($id);
                $article->downvotes -= 1;
                $voteStatus = 0;
            } else {
                $article->voteArticleTransaction($user->id, $id, 'Downvote', $article->author_id, $user->id, now());
                $article->upvotes -= 1;
                $voteStatus = -1;
            }
        } else {
            $article->voteArticleTransaction($user->id, $id, 'Downvote', $article->author_id, $user->id, now());
            $voteStatus = -1;
        }

        $article->save();

        $article->refresh();

        return response()->json([
            'article' => $article,
            'voteStatus' => $voteStatus
        ]);
    }

    public function favourite(Request $request, $id): JsonResponse
    {
        $article = ArticlePage::findOrFail($id);

        // TODO SPECIAL FEEDBACK WHEN ARTICLE IS DELETED (NO INTERACTIONS ALLOWED)

        $this->authorize('favourite', $article); // TODO REDIRECT TO LOGIN

        /** @var User $user */
        $user = Auth::user();
        // Get "true" or "false" sent in request (convert to boolean)
        $isFavourite = filter_var($request->input('isFavourite'), FILTER_VALIDATE_BOOLEAN);

        // Log::info("The isFavourite value is: " . var_export($isFavourite, true));

        if ($isFavourite) {
            $user->favouriteArticles()->detach($id);
            $favouriteStatus = 0;
        }
        else {
            $user->favouriteArticles()->attach($id);
            $favouriteStatus = 1;
        }

        return response()->json([
            'favouriteStatus' => $favouriteStatus
        ]);
    }

    public function writeComment(Request $request, $id): JsonResponse
    {
        // Log::info('Comment request: ' . json_encode($request->all()));
        /** @var User $user */
        $user = auth()->user();
        $article = ArticlePage::findOrFail($id);

        if ($article->is_deleted) { // TODO review
            return response()->json(['error' => 'Article is deleted'], 404);
        }
        $this->authorize('create', Comment::class);

        $request->validate([
            'comment' => 'required|string|max:300',
        ]);

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


    public function upvoteComment($id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        //$this->authorize('upvote', Comment::class);

        $comment = Comment::findOrFail($id);
        $vote = $comment->voters()->where('user_id', $user->id)->first();

        if ($vote) {
            if ($vote->pivot->type === 'Upvote') {
                $comment->voters()->detach($user->id);
                $comment->upvotes--;
                $isUpvoted = false;
            } else {
                $comment->voteCommentTransaction($user->id, $id, 'Upvote', $comment->author_id, $user->id, now());
                $comment->downvotes--;
                $isUpvoted = true;
            }
        } else {
            $comment->voteCommentTransaction($user->id, $id, 'Upvote', $comment->author_id, $user->id, now());
            $isUpvoted = true;
        }

        $comment->save();
        $comment->refresh();

        return response()->json([
            'comment' => $comment,
            'isUpvoted' => $isUpvoted,
        ]);
    }

    public function downvoteComment($id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        //$this->authorize('downvote', Comment::class);

        $comment = Comment::findOrFail($id);
        $vote = $comment->voters()->where('user_id', $user->id)->first();

        if ($vote) {
            if ($vote->pivot->type === 'Downvote') {
                $comment->voters()->detach($user->id);
                $comment->downvotes--;
                $isDownvoted = false;
            } else {
                $comment->voteCommentTransaction($user->id, $id, 'Downvote', $comment->author_id, $user->id, now());
                $comment->upvotes--;
                $isDownvoted = true;
            }
        } else {
            $comment->voteCommentTransaction($user->id, $id, 'Downvote', $comment->author_id, $user->id, now());
            $isDownvoted = true;
        }

        $comment->save();
        $comment->refresh();

        return response()->json([
            'comment' => $comment,
            'isDownvoted' => $isDownvoted,
        ]);
    }

    public function upvoteReply($id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $this->authorize('upvote', Reply::class);

        $reply = Reply::findOrFail($id);
        $vote = $reply->voters()->where('user_id', $user->id)->first();
        if ($vote) {
            if ($vote->pivot->type === 'Upvote') {
                $reply->voters()->detach($user->id);
                $reply->upvotes--;
                $isUpvoted = false;
            }
            else {
                $vote->pivot->type = 'Upvote';
                $vote->pivot->save();
                $reply->upvotes++;
                $reply->downvotes--;
                $isUpvoted = true;
            }
        }
        else {
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

    public function downvoteReply($id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $this->authorize('downvote', Reply::class);

        $reply = Reply::findOrFail($id);
        $vote = $reply->voters()->where('user_id', $user->id)->first();
        if ($vote) {
            if ($vote->pivot->type === 'Downvote') {
                $reply->voters()->detach($user->id);
                $reply->downvotes--;
                $isDownvoted = false;
            }
            else {
                $vote->pivot->type = 'Downvote';
                $vote->pivot->save();
                $reply->downvotes++;
                $reply->upvotes--;
                $isDownvoted = true;
            }
        }
        else {
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

    public function deleteComment($id): JsonResponse
    {
        $comment = Comment::find($id);
        $comment->is_deleted = true;
        $comment->save();

        $this->authorize('delete', $comment);

        $commentsView = view('partials.comment', ['comment' => $comment, 'user' => Auth::user(), 'isReply' => false, 'replies' => $comment->replies])->render();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
            'commentsView' => $commentsView
        ]);
    }

    public function deleteReply($id): JsonResponse
    {
        $reply = Reply::find($id);
        $reply->is_deleted = true;
        $reply->save();

        $this->authorize('delete', $reply);

        $commentsView = view('partials.comment', ['comment' => $reply, 'user' => Auth::user(), 'isReply' => false, 'replies' => $reply->replies])->render();
        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
            'commentsView' => $commentsView
        ]);
    }

    public function showCommentForm($id, Request $request): View
    {
        $comment = $request->state === 'editReply' ?  Reply::findOrFail($id) : Comment::findOrFail($id);
        $article = ArticlePage::findOrFail($request->articleId);
        $user = auth()->user();

        $this->authorize('create', Comment::class);

        return view('partials.comment_write_form', [
            'user' => $user,
            'article' => $article,
            'state' => $request->state === 'reply' ? 'replyComment' : 'editComment',
            'comment' => $comment
        ]);
    }

    public function editComment($id, Request $request): JsonResponse
    {
        Log::info('Edit comment request: ' . json_encode($request->all()));
        $comment = $request->isReply === 'true' ? Reply::findOrFail($id) : Comment::findOrFail($id);
        Log::info('Comment found: ' . json_encode($comment));
        $comment->content = $request->comment;
        $comment->save();

        $this->authorize('update', $comment);

        Log::info('Comment edited: ' . json_encode($comment));

        $commentsView = view('partials.comment', ['comment' => $comment, 'user' => Auth::user(), 'isReply' => $request->isReply , 'replies' => $comment->replies])->render();
        return response()->json([
            'success' => true,
            'message' => 'Comment edited successfully',
            'commentsView' => $commentsView
        ]);
    }

    public function replyComment($id, Request $request): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('create', Reply::class);

        $request->validate([
            'comment' => 'required|string|max:300',
        ]);

        $reply = new Reply();
        $reply->author_id = auth()->id();
        $reply->comment_id = $comment->id;
        $reply->content = $request->comment;
        $reply->save();

        $replyView = view('partials.comment', [
            'comment' => $reply,
            'user' => Auth::user(),
            'isReply' => true,
        ])->render();

        return response()->json([
            'success' => true,
            'message' => 'Reply added successfully',
            'replyView' => $replyView
        ]);
    }

    public function showReportArticleModal($id): View
    {
        $article = ArticlePage::findOrFail($id);

        $this->authorize('report', $article);

        return view('partials.report_article_modal', ['articleId' => $id, 'state' => 'reportArticle']);
    }

    public function reportArticleSubmit($id, Request $request): JsonResponse
    {
        Log::info('Report request: ' . json_encode($request->all()));
        
        $author = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('report', $article);

        $report = new Report();
        $report->description = $request->description;
        $report->reporter_id = $author->id;
        $report->save();
        
        $reportArticle = new ReportArticle();
        $reportArticle->type = $request->type;
        $reportArticle->report_id = $report->id;
        $reportArticle->article_id = $article->id;
        $reportArticle->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Article reported successfully'
        ]);
    }

    public function showReportCommentModal($id, Request $request): View
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('report', $comment);

        return view('partials.report_article_modal', ['commentId' => $id, 'state' => $request->isReply ? 'reportReply' : 'reportComment']);
    }

    public function reportCommentSubmit($id, Request $request): JsonResponse
    {
        Log::info('Report request: ' . json_encode($request->all()));

        $author = Auth::user();

        if ($request->isReply) {
            $reply = Reply::findOrFail($id);
            $this->authorize('report', $reply);

        }
        else {
            $comment = Comment::findOrFail($id);
            $this->authorize('report', $comment);

        }

        $report = new Report();
        $report->description = $request->description;
        $report->reporter_id = $author->id;
        $report->save();

        $reportComment = new ReportComment();
        $reportComment->type = $request->type;
        $reportComment->report_id = $report->id;

        if ($request->isReply) {
            $reportComment->reply_id = $id;
        }
        else {
            $reportComment->comment_id = $id;
        }
        $reportComment->save();

        return response()->json([
            'success' => true,
            'message' => 'Article reported successfully'
        ]);
    }

    public function showReportUserModal($id): View
    {
        $targetUser = User::findOrFail($id);

        $this->authorize('report', $targetUser);

        return view('partials.report_article_modal', ['userId' => $id, 'state' => 'reportUser']);
    }

    public function reportUserSubmit($id, Request $request): JsonResponse
    {
        Log::info('Report request: ' . json_encode($request->all()));
        Log::info('User id: ' . $id);

        $author = Auth::user();

        $report = new Report();
        $report->description = $request->description;
        $report->reporter_id = $author->id;

        $report->save();

        $reportUser = new ReportUser();
        $reportUser->type = $request->type;
        $reportUser->report_id = $report->id;
        $reportUser->user_id = $id;

        $reportUser->save();

        return response()->json([
            'success' => true,
            'message' => 'Article reported successfully'
        ]);
    }

}


