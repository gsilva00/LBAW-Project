<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{

    public function followTopic(Request $request, Topic $topic): RedirectResponse
    {
        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();
        $user->followedTopics()->attach($topic->id);

        return redirect()->back()->with('success', 'Topic followed successfully.');
    }

    public function unfollowTopic(Request $request, Topic $topic): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->followedTopics()->detach($topic->id);

        return redirect()->back()->with('success', 'Topic unfollowed successfully.');
    }
}