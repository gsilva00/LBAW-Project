<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminPanelController extends Controller
{
    /**
     * Show the administrator panel.
     * - Uses pagination to show user list.
     */
    public function show(): View|RedirectResponse
    {
        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();

        if (Auth::guest() || $user->cant('viewAdminPanel', User::class)) {
            return redirect()->route('homepage')->with('error', 'Unauthorized. You do not possess the valid credentials to access that page.');
        }

        $users = User::where([
            ['is_admin', false],
            ['is_deleted', false]
        ])->paginate(10);

        // TODO expand for more administrator features

        return view('pages.admin_panel', [
            'user' => $user,
            'users' => $users,
            'currPageNum' => 1,
            'hasMorePages' => $users->hasMorePages(),
        ]);
    }

    /**
     * Pagination to get more users everytime the "Load more" button is clicked
     */
    public function moreUsers(Request $request): JsonResponse
    {
        $this->authorize('viewAdminPanel', User::class);

        $page = $request->get('page', 1);
        $users = User::where([
            ['is_admin', false],
            ['is_deleted', false]
        ])->paginate(10, ['*'], 'page', $page);

        $view = view('partials.user_tile_list', [
            'users' => $users
        ])->render();

        return response()->json([
            'html' => $view,
            'hasMorePages' => $users->hasMorePages(),
        ]);
    }

    public function createFullUser(Request $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'password' => 'required|string|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'reputation' => 'nullable|integer|min:0|max:5',
            'upvote_notification' => 'nullable|boolean',
            'comment_notification' => 'nullable|boolean',
            'is_admin' => 'nullable|boolean',
            'is_fact_checker' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        $profile_picture_path = 'default.jpg';
        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '-' . $request->file('profile_picture')->getClientOriginalName();
            $request->file('profile_picture')->move(public_path('images/profile'), $imageName);
            $profile_picture_path = $imageName;
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'display_name' => $request->display_name,
            'description' => $request->description,
            'profile_picture' => $profile_picture_path,
            'reputation' => $request->input('reputation', 3),
            'upvote_notification' => $request->input('upvote_notification', true),
            'comment_notification' => $request->input('comment_notification', true),
            'is_admin' => $request->input('is_admin', false),
            'is_fact_checker' => $request->input('is_fact_checker', false),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'user' => $user,
        ]);
    }
}
