<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        ])->paginate(config('pagination.users_per_page'));

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
        ])->paginate(config('pagination.users_per_page'), ['*'], 'page', $page);

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
        if ($request->hasFile('file')) {
            $fileController = new FileController();
            $imageName = $fileController->uploadImage($request, 'profile');
            $profile_picture_path = $imageName;
        }

        // Mass-assign non-sensitive fields
        $user = User::create([
            'display_name' => $request->input('display_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'description' => $request->input('description'),
            'profile_picture' => $profile_picture_path,
            'reputation' => $request->input('reputation'),
            'upvote_notification' => $request->input('upvote_notification', false),
            'comment_notification' => $request->input('comment_notification', false),
        ]);

        // Set sensitive fields manually
        $user->is_admin = $request->input('is_admin', false);
        $user->is_fact_checker = $request->input('is_fact_checker', false);
        $user->save();

        /*Log::info('User created with values:', [
            'username' => $user->username,
            'email' => $user->email,
            'display_name' => $user->display_name,
            'description' => $user->description,
            'profile_picture' => $user->profile_picture,
            'reputation' => $user->reputation,
            'upvote_notification' => $user->upvote_notification,
            'comment_notification' => $user->comment_notification,
            'is_admin' => $user->is_admin,
            'is_fact_checker' => $user->is_fact_checker,
            'is_deleted' => $user->is_deleted,
            'is_banned' => $user->is_banned,
            'remember_token' => $user->remember_token,
        ]);*/

        // Handle pagination
        $usersPerPage = config('pagination.users_per_page');
        $totalUsers = User::where([
            ['is_admin', false],
            ['is_deleted', false],
        ])->count();
        $userPos = $totalUsers-1; // Not counting the new one

        $currentPageNum = (int) $request->input('currentPageNum', 1);
        $pageFirstPos = ($currentPageNum-1) * $usersPerPage;
        $pageLastPos = $pageFirstPos+$usersPerPage - 1;

        $newUserHtml = null;
        if ($userPos >= $pageFirstPos && $userPos <= $pageLastPos && !$user->is_admin) {
            // If the new user belongs on the current page, generate its HTML
            $newUserHtml = view('partials.user_tile', [
                'user' => $user
            ])->render();
        }

        return response()->json([
            'user' => $user,
            'success' => true,
            'message' => 'User created successfully.',
            'isAfterLast' => $userPos > $pageLastPos,
            'newUserHtml' => $newUserHtml,
        ]);
    }
}
