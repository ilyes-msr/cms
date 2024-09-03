<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Auth\Events\Validated;

class PostController extends Controller
{

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->middleware('auth')->except(['index', 'show', 'posts_by_category']);
    }

    public function index()
    {
        $posts = $this->post::with('user:id,name,profile_photo_path')->approved()->paginate(10);

        $title = "جميع المنشورات";

        return view('index', compact('posts', 'title'));
    }

    public function posts_by_category($category_id)
    {
        $posts = $this->post::with('user:id,name,profile_photo_path')->where('category_id', $category_id)->approved()->paginate(10);

        $category = Category::findOrFail($category_id)->title;

        // $category = $posts[0]?->category->title;

        $title = "منشورات الصنف: " . $category;

        return view('index', compact('posts', 'title'));
    }

    public function create()
    {
        $title = "إضافة منشور جديد";
        return view('posts.create', compact('title'));
    }

    public function store(StorePostRequest $request)
    {

        $validated = $request->validated();

        // dd($validated);

        $post = new Post();
        $post->title = $validated['title'];
        $post->slug = slugify($validated['title']);
        $post->body = $validated['body'];
        $post->user_id = auth()->id();
        $post->category_id = $validated['category_id'];

        if ($request->hasFile('img_path')) {
            $path = $request->file('img_path')->store('images/posts', 'public');
            $post->img_path = $path;
        } else {
            $post->img_path = "images/posts/default.jpg";
        }

        $post->save();

        return redirect()->route('post.index')->with('success', 'تم انشاء المنشور بنجاح');
    }

    public function show($slug)
    {
        $post = $this->post->where(['slug' => $slug, 'approved' => 1])->firstOrFail();
        // dd($post->comments);
        $comments = $post->comments->sortByDesc('created_at');
        return view('posts.show', compact('post', 'comments'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $title = "تعديل المنشور";
        $categories = Category::all();
        return view('posts.edit', compact('post', 'title', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $data['slug'] = slugify($request->title);
        $data['category_id'] = $request->category_id;

        if ($request->hasFile('img_path')) {
            $path = $request->file('img_path')->store('images/posts', 'public');
        } else {
            $path = Post::where('slug', $slug)->first()->img_path;
        }

        $request->user()->posts()->where('slug', $slug)->update($data + ['img_path' => $path]);

        return redirect(route('post.show', $data['slug']))->with('success', 'تم تعديل المنشور بنجاح');
    }


    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return back()->with('success', 'تم الحذف بنجاح');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $posts = $this->post->where('title', 'like', "%{$keyword}%")->orWhere('body', 'like', "%{$keyword}%")->with('user')->approved()->paginate(10);

        $title = "نتائج البحث عن: " . $keyword;

        return view('index', compact('posts', 'title'));
    }
}
