<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{

    public function followTag(Request $request, Tag $tag)
    {
        $user = Auth::user();
        $user->followedTags()->attach($tag->id);

        return redirect()->back()->with('success', 'Tag followed successfully.');
    }

    public function unfollowTag(Request $request, Tag $tag)
    {
        $user = Auth::user();
        $user->followedTags()->detach($tag->id);

        return redirect()->back()->with('success', 'Tag unfollowed successfully.');
    }
}