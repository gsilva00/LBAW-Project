<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CreateArticleController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $this->authorize('create', ArticlePage::class);

        try {
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
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        $topics = $request->input('topics');
        if (in_array('No_Topic', $topics)) {
            return redirect()->back()->withErrors(['topics' => 'Please choose a valid topic.'])->withInput();
        }

        $topicId = intval($topics[0]);

        $article = new ArticlePage();
        $article->title = $request->input('title');
        $article->subtitle = $request->input('subtitle');
        $article->content = str_replace("\n", "<?n?n>", $request->input('content'));
        $article->author_id = Auth::id();
        $article->topic_id = $topicId;

        if ($request->hasFile('article_picture')) {
            $imageName = time() . '-' . $request->file('article_picture')->getClientOriginalName();
            $request->file('article_picture')->move(public_path('images/article'), $imageName);
            $article->article_image = $imageName;
        }

        $article->save();

        $tagIds = Tag::searchByArrayNames($request->input('tags', []));
        $article->tags()->sync($tagIds);

        return redirect()->route('profile', ['username' => $user->username])->with('success', 'Article created successfully!');
    }

    public function create(){
        $user = Auth::user();

        if (Auth::guest() || !Auth::user()->can('create', ArticlePage::class)) {
            return redirect()->route('login')->with('error', 'Unauthorized. You do not possess the credentials to create an article.');
        }

        return view('pages.create_article', ['user' => $user]);
    }

    public function edit(Request $request, $id){
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('update', $article);

        $tags = Tag::searchByArticleId($id);

        $article->content = str_replace('<?n?n>', "\n", $article->content);

        return view('pages.edit_article', ['user' => $user, 'article' => $article, 'tags' => $tags]);
    }

    public function update(Request $request, $id)
    {
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


        /*Log::info('CreateArticleController@show', [
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'content' => $request->input('content')
        ]);*/

        $article->title = $request->input('title');
        $article->subtitle = $request->input('subtitle');
        $article->content = str_replace("\n", "<?n?n>", $request->input('content'));
        $article->topic_id = $topicId;

        if ($request->hasFile('article_picture')) {
            $imageName = time() . '-' . $request->file('article_picture')->getClientOriginalName();
            $request->file('article_picture')->move(public_path('images/article'), $imageName);
            $article->article_image = $imageName;
        }

        $article->save();

        /*Log::info('EditArticleController@show', [
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'content' => $request->input('content'),
            'tags' => $request->input('tags'),
            'topics' => $request->input('topics'),
            'article_picture' => $request->file('article_picture'),
        ]);*/

        Tag::removeAllTagsByArticleId($id);
        $tagIds = Tag::searchByArrayNames($request->input('tags', []));
        $article->tags()->sync($tagIds);

        return redirect()->route('profile', ['username' => $user->username])->with('success', 'Article updated successfully!');
    }

    public function delete(Request $request, $id)
    {
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('delete', $article);

        $article->title = '[Deleted]';
        $article->subtitle = '[Deleted]';
        $article->content = '[Deleted]';
        $article->article_image = 'images/article/default.png';
        $article->is_deleted = true;
        $article->save();

        return redirect()->route('profile', ['username' => $user->username])->with('success', 'Article deleted successfully!');
    }

}
