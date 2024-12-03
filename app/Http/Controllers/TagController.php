<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{

    public function followTag(Request $request, Tag $tag): RedirectResponse
    {
        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();
        $user->followedTags()->attach($tag->id);

        return redirect()->back()->with('success', 'Tag followed successfully.');
    }

    public function unfollowTag(Request $request, Tag $tag): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->followedTags()->detach($tag->id);

        return redirect()->back()->with('success', 'Tag unfollowed successfully.');
    }
}