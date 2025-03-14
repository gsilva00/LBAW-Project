<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
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

class CreateArticleController extends Controller
{
    public function store(Request $request): View|RedirectResponse
    {
        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();

        $this->authorize('create', ArticlePage::class);

        $request->validate([
            'title' => 'required|string|max:50',
            'subtitle' => 'required|string|max:50',
            'content' => 'string|max:10000',
            'topics' => 'required|exists:topic,id',
            'article_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'topics.required' => 'Please choose a topic.',
            'topics.exists' => 'The selected topic is invalid.',
        ]);

        $topics = $request->input('topics');
        if (in_array('No_Topic', $topics)) {
            return redirect()->back()
                ->withErrors(['topics' => 'Please choose a valid topic.'])->withInput();
        }

        $topicId = intval($topics[0]);

        $article = new ArticlePage();
        $article->title = $request->input('title');
        $article->subtitle = $request->input('subtitle');
        $article->content = str_replace("\n", "<?n?n>", $request->input('content'));
        $article->author_id = Auth::id();
        $article->topic_id = $topicId;

        if ($request->hasFile('file')) {
            $fileController = new FileController();
            $imageName = $fileController->uploadImage($request, 'article');
            $article->article_image = $imageName;
        }

        $article->save();

        $tagIds = Tag::searchByArrayNames($request->input('tags', []));
        $article->tags()->sync($tagIds);

        return redirect()->route('profile', ['username' => $user->username])
            ->withSuccess('Article created successfully!');
    }

    public function create(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            $this->authorize('create', ArticlePage::class);
        }
        catch (AuthorizationException $e) {
            return redirect()->route('login')
                ->withErrors('Unauthorized. You need to login to create an article.');
        }

        return view('pages.create_article', [
            'user' => $user
        ]);
    }

    public function edit(Request $request, $id): View
    {
        /** @var User $user */
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('update', $article);

        $tags = Tag::searchByArticleId($id);

        $article->content = str_replace('<?n?n>', "\n", $article->content);

        return view('pages.edit_article', [
            'user' => $user,
            'article' => $article,
            'tags' => $tags
        ]);
    }

    public function update(Request $request, $id): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('update', $article);

        $request->validate([
            'title' => 'required|string|max:50',
            'subtitle' => 'required|string|max:50',
            'content' => 'string|max:10000',
            'topics' => 'required|exists:topic,id',
        ]);

        $topicId = intval($request->input('topics')[0]);

        $article->title = $request->input('title');
        $article->subtitle = $request->input('subtitle');
        $article->content = str_replace("\n", "<?n?n>", $request->input('content'));
        $article->topic_id = $topicId;

        if ($request->hasFile('file')) {
            $fileController = new FileController();
            if ($article->article_image !== 'default.jpg') {
                $imageName = $fileController->uploadImage($request, 'article', $article->article_image);
            }
            else {
                $imageName = $fileController->uploadImage($request, 'article');
            }
            $article->article_image = $imageName;
        }

        $article->save();

        Tag::removeAllTagsByArticleId($id);
        $tagIds = Tag::searchByArrayNames($request->input('tags', []));
        $article->tags()->sync($tagIds);

        return redirect()->route('profile', ['username' => $user->username])
            ->withSuccess('Article updated successfully!');
    }

    public function delete(Request $request, $id): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('delete', $article);

        $article->title = '[Deleted]';
        $article->subtitle = '[Deleted]';
        $article->content = '[Deleted]';
        $article->article_image = 'images/article/default.png';
        $article->is_deleted = true;
        $article->save();

        return redirect()->route('profile', ['username' => $user->username])
            ->withSuccess('Article deleted successfully!');
    }


    public function proposeNewTagShow(): View
    {
        return view('partials.propose_new_tag');
    }

    public function proposeNewTag(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $tag = new ProposeNewTag();
        $tag->name = $request->input('name');
        $tag->user_id = Auth::id();
        $tag->save();

        return response()->json([
            'success' => true,
            'message' => 'Tag proposed successfully!'
        ]);
    }

}
