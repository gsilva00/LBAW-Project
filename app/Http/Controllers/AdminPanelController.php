<?php

namespace App\Http\Controllers;

use App\Models\AppealToUnban;
use App\Models\ProposeNewTag;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\User;

use Illuminate\Auth\Access\AuthorizationException;
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

        try {
            $this->authorize('viewAdminPanel', User::class);
        } catch (AuthorizationException $e) {
            return redirect()->route('homepage')
                ->withErrors('Unauthorized. You do not possess the valid credentials to access that page.');
        }

        $users = User::where([
            ['is_admin', false],
            ['is_deleted', false]
        ])->orderBy('display_name')->paginate(config('pagination.users_per_page'));

        $topics = Topic::orderBy('name')->paginate(config('pagination.topics_per_page'));

        $tags = Tag::orderBy('name')->paginate(config('pagination.tags_per_page'));

        $tag_proposals = ProposeNewTag::paginate(config('pagination.tag_proposals_per_page'));

        $unban_appeals = AppealToUnban::paginate(config('pagination.unban_appeals_per_page'));

        return view('pages.admin_panel', [
            'user' => $user,
            'userCurrPageNum' => 1, // User pagination
            'userHasMorePages' => $users->hasMorePages(),
            'usersPaginated' => $users,
            'topicCurrPageNum' => 1, // Topic pagination
            'topicHasMorePages' => $topics->hasMorePages(),
            'topicsPaginated' => $topics,
            'tagCurrPageNum' => 1, // Tag pagination
            'tagHasMorePages' => $tags->hasMorePages(),
            'tagsPaginated' => $tags,
            'tagProposalCurrPageNum' => 1, // Tag proposal pagination
            'tagProposalHasMorePages' => $tag_proposals->hasMorePages(),
            'tagProposalsPaginated' => $tag_proposals,
            'unbanAppealCurrPageNum' => 1, // Unban appeal pagination
            'unbanAppealHasMorePages' => $unban_appeals->hasMorePages(),
            'unbanAppealsPaginated' => $unban_appeals,
        ]);
    }


    // Handle positioning of the newly created entity in context of pagination
    private function newItemPag($modelClass, $newEntity, $currPageNum, $perPage, $viewPartial): array
    {
        $totalEntities = $modelClass::count();
        $newEntityPos = $totalEntities - 1;

        $pageFirstPos = ($currPageNum - 1) * $perPage;
        $pageLastPos = $pageFirstPos + $perPage - 1;

        $entityHtml = null;
        if ($newEntityPos >= $pageFirstPos && $newEntityPos <= $pageLastPos) {
            $entityHtml = view($viewPartial, [
                $newEntity->getTable() => $newEntity,
            ])->render();
        }

        return [
            'isAfterLast' => $newEntityPos > $pageLastPos,
            'entityHtml' => $entityHtml,
        ];
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
        ])->orderBy('display_name')->paginate(
            config('pagination.users_per_page'),
            ['*'],
            'page',
            $page
        );

        $view = view('partials.user_tile_list', [
            'usersPaginated' => $users,
            'isAdminPanel' => true,
        ])->render();

        return response()->json([
            'newHtml' => $view,
            'userHasMorePages' => $users->hasMorePages(),
        ]);
    }

    public function createFullUser(Request $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|regex:/^[a-zA-Z0-9._-]+$/|max:20|unique:users',
            'email' => 'required|string|email|max:256|unique:users',
            'display_name' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:300',
            'password' => 'required|string|min:8|max:256',
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
            ], 422);
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

        // Handle pagination
        $pagination = $this->newItemPag(
            User::class,
            $user,
            (int)$request->input('currPageNum', 1),
            config('pagination.users_per_page'),
            'partials.user_tile'
        );

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'user' => $user,
            'isAfterLast' => $pagination['isAfterLast'],
            'newHtml' => $pagination['entityHtml'],
        ]);
    }

    public function banUser(int $id): JsonResponse
    {
        $this->authorize('ban', User::class);

        $user = User::findOrFail($id);
        $user->is_banned = true;
        $user->save();

        return response()->json([
            'success' => true,
            'is_banned' => true,
            'message' => 'User banned successfully.',
            'new_action' => 'unban',
            'new_action_route' => route('adminUnbanUser', ['id' => $user->id]),
        ]);
    }

    public function unbanUser(int $id): JsonResponse
    {
        $this->authorize('unban', User::class);

        $user = User::findOrFail($id);
        $user->is_banned = false;
        $user->save();

        return response()->json([
            'success' => true,
            'is_banned' => false,
            'message' => 'User unbanned successfully.',
            'new_action' => 'ban',
            'new_action_route' => route('adminBanUser', ['id' => $user->id]),
        ]);
    }


    public function moreTopics(Request $request): JsonResponse
    {
        $this->authorize('viewAdminPanel', User::class);

        $page = $request->get('page', 1);
        $topics = Topic::orderBy('name')->paginate(
            config('pagination.topics_per_page'),
            ['*'],
            'page',
            $page
        );

        $view = view('partials.topic_tile_list', [
            'topicsPaginated' => $topics
        ])->render();


        return response()->json([
            'newHtml' => $view,
            'topicHasMorePages' => $topics->hasMorePages(),
        ]);
    }

    public function createTopic(Request $request): JsonResponse
    {
        $this->authorize('create', Topic::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30|unique:topic',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Failed to create topic.'
            ], 422);
        }

        $topic = Topic::create([
            'name' => $request->input('name'),
        ]);


        $pagination = $this->newItemPag(
            Topic::class,
            $topic,
            (int)$request->input('currPageNum', 1),
            config('pagination.topics_per_page'),
            'partials.topic_tile'
        );

        return response()->json([
            'success' => true,
            'message' => 'Topic created successfully.',
            'topic' => $topic,
            'isAfterLast' => $pagination['isAfterLast'],
            'newHtml' => $pagination['entityHtml'],
        ]);
    }


    public function moreTags(Request $request): JsonResponse
    {
        $this->authorize('viewAdminPanel', User::class);

        $page = $request->get('page', 1);
        $tags = Tag::orderBy('name')->paginate(
            config('pagination.tags_per_page'),
            ['*'],
            'page',
            $page
        );

        $view = view('partials.tag_tile_list', [
            'tagsPaginated' => $tags
        ])->render();

        return response()->json([
            'newHtml' => $view,
            'tagHasMorePages' => $tags->hasMorePages(),
        ]);
    }

    public function createTag(Request $request): JsonResponse
    {
        $this->authorize('create', Tag::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30|unique:tag',
            'is_trending' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Failed to create tag.',
            ], 400);
        }

        $tag = Tag::create([
            'name' => $request->input('name'),
            'is_trending' => $request->input('is_trending', false),
        ]);


        $pagination = $this->newItemPag(
            Tag::class,
            $tag,
            (int)$request->input('currPageNum', 1),
            config('pagination.tags_per_page'),
            'partials.tag_tile'
        );

        return response()->json([
            'success' => true,
            'message' => 'Tag created successfully.',
            'tag' => $tag,
            'isAfterLast' => $pagination['isAfterLast'],
            'newHtml' => $pagination['entityHtml'],
        ]);
    }

    public function toggleTrending(int $id): JsonResponse
    {
        $tag = Tag::findOrFail($id);

        $this->authorize('update', $tag);

        $tag->is_trending = !$tag->is_trending;
        $tag->save();

        return response()->json([
            'success' => true,
            'is_trending' => $tag->is_trending,
            'message' => $tag->is_trending ? 'Tag added to trending.' : 'Tag removed from trending.',
        ]);
    }


    public function moreTagProposals(Request $request): JsonResponse
    {
        $this->authorize('viewAdminPanel', User::class);

        $page = $request->get('page', 1);
        $proposals = ProposeNewTag::orderBy('name')->paginate(
            config('pagination.tag_proposals_per_page'),
            ['*'],
            'page',
            $page
        );

        $view = view('partials.propose_tag_tile_list', [
            'tagProposalsPaginated' => $proposals
        ])->render();

        return response()->json([
            'newHtml' => $view,
            'tagProposalHasMorePages' => $proposals->hasMorePages(),
        ]);
    }

    public function acceptTagProposal(int $id): JsonResponse
    {
        $this->authorize('accept', ProposeNewTag::class);

        $proposal = ProposeNewTag::findOrFail($id);
        $proposal->delete();

        $tag = Tag::create([
            'name' => $proposal->name
        ]);

        $tagHtml = view('partials.tag_tile', ['tag' => $tag])->render();

        return response()->json([
            'success' => true,
            'message' => 'Tag proposal accepted and added to tags.',
            'newHtml' => $tagHtml,
        ]);
    }

    public function rejectTagProposal(int $id): JsonResponse
    {
        $this->authorize('reject', ProposeNewTag::class);

        $proposal = ProposeNewTag::findOrFail($id);
        $proposal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag proposal rejected.',
        ]);
    }


    public function moreUnbanAppeals(Request $request): JsonResponse
    {
        $this->authorize('viewAdminPanel', User::class);

        $page = $request->get('page', 1);
        $appeals = AppealToUnban::paginate(
            config('pagination.unban_appeals_per_page'),
            ['*'],
            'page',
            $page
        );

        $view = view('partials.unban_appeal_tile_list', [
            'unbanAppealsPaginated' => $appeals
        ])->render();

        return response()->json([
            'newHtml' => $view,
            'unbanAppealHasMorePages' => $appeals->hasMorePages(),
        ]);
    }

    public function acceptUnbanAppeal(int $id): JsonResponse
    {
        $this->authorize('accept', AppealToUnban::class);

        $appeal = AppealToUnban::findOrFail($id);
        $appeal->delete();

        $user = $appeal->user;
        $user->is_banned = false;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Unban appeal accepted and user unbanned.',
        ]);
    }

    public function rejectUnbanAppeal(int $id): JsonResponse
    {
        $this->authorize('reject', AppealToUnban::class);

        $appeal = AppealToUnban::findOrFail($id);
        $appeal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unban appeal rejected.',
        ]);
    }
}
