<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function showTopic(string $name): View
    {
        $topic = Topic::where('name', $name)->firstOrFail();

        $this->authorize('view', $topic);

        $articles = $topic->articles()->get();

        return view('pages.topic_page', [
            'user' => Auth::user(),
            'topic' => $topic,
            'articles' => $articles
        ]);
    }

    public function followTopic(string $name): RedirectResponse
    {
        $this->authorize('follow', Topic::class);

        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();

        $topic = Topic::where('name', $name)->firstOrFail();
        $user->followedTopics()->attach($topic->id);

        return redirect()->back()->with('success', 'Topic followed successfully.');
    }

    public function unfollowTopic(string $name): RedirectResponse
    {
        $this->authorize('unfollow', Topic::class);

        /** @var User $user */
        $user = Auth::user();

        $topic = Topic::where('name', $name)->firstOrFail();
        $user->followedTopics()->detach($topic->id);

        return redirect()->back()->with('success', 'Topic unfollowed successfully.');
    }
}