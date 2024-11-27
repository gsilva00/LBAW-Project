<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{

    public function followTopic(Request $request, Topic $topic)
    {
        $user = Auth::user();
        $user->followedTopics()->attach($topic->id);

        return redirect()->back()->with('success', 'Topic followed successfully.');
    }

    public function unfollowTopic(Request $request, Topic $topic)
    {
        $user = Auth::user();
        $user->followedTopics()->detach($topic->id);

        return redirect()->back()->with('success', 'Topic unfollowed successfully.');
    }
}