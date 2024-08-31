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
        $this->middleware('auth')->except(['index', 'show']);
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

        return view('posts.show', compact('post'));
    }

    public function edit($id) {}

    public function update(Request $request, $id) {}


    public function destroy($id) {}

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $posts = $this->post->where('title', 'like', "%{$keyword}%")->orWhere('body', 'like', "%{$keyword}%")->with('user')->approved()->paginate(10);

        $title = "نتائج البحث عن: " . $keyword;

        return view('index', compact('posts', 'title'));
    }
}
