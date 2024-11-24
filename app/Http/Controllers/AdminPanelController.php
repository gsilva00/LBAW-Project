<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPanelController extends Controller
{
    /**
     * Show the administrator panel.
     * - Uses pagination to show user list.
     */
    public function show(User $user)
    {
        $user = Auth::user();

        $this->authorize('viewAdminPanel', $user);

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
}
