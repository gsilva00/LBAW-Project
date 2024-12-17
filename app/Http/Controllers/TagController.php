<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function showTag(string $name): View
    {
        $tag = Tag::where('name', $name)->firstOrFail();

        $this->authorize('view', $tag);

        $articles = $tag->articles()->get();

        return view('pages.tag_page', [
            'user' => Auth::user(),
            'tag' => $tag,
            'articles' => $articles
        ]);
    }

    public function showTrendingTags(): View
    {
        $this->authorize('viewAny', Tag::class);

        $trendingTags = Tag::where('is_trending', true)
            ->withCount(['articles' => function ($query) {
                $query->where('is_deleted', false);
            }])
            ->get();
        $trendingTagsNewsCount = $trendingTags->sum('articles_count');

        return view('pages.trending_tags', [
            'user' => Auth::user(),
            'trendingTags' => $trendingTags,
            'trendingTagsNewsCount' => $trendingTagsNewsCount
        ]);
    }

    public function followTag(string $name): RedirectResponse
    {
        $this->authorize('follow', Tag::class);

        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();

        $tag = Tag::where('name', $name)->firstOrFail();
        $user->followedTags()->attach($tag->id);

        return redirect()->back()->with('success', 'Tag followed successfully.');
    }

    public function unfollowTag(string $name): RedirectResponse
    {
        $this->authorize('unfollow', Tag::class);

        /** @var User $user */
        $user = Auth::user();

        $tag = Tag::where('name', $name)->firstOrFail();
        $user->followedTags()->detach($tag->id);

        return redirect()->back()->with('success', 'Tag unfollowed successfully.');
    }
}