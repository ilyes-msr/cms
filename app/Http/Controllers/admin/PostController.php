<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post::with('user', 'category', 'comments')->get();
        return view('admin.posts.all', compact('posts'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $post = $this->post::find($id);
        $categories = Category::all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request['approved'] = $request->has('approved');

        if ($request->hasFile('img_path')) {
            $path = $request->file('img_path')->store('images/posts', 'public');
        } else {
            $path = Post::find($id)->img_path;
        }

        $data['title'] = $request->title;
        $data['slug'] = $request->slug;
        $data['body'] = $request->body;
        $data['category_id'] = $request->category_id;
        $data['img_path'] = $path;
        $data['approved'] = $request->approved;

        $this->post->find($id)->update($data);

        return redirect(route('posts.index'))->with('success', 'تم تعديل المنشور بنجاح');
    }

    public function destroy($id)
    {
        $this->post->find($id)->delete();
        return back()->with('success', 'تم حذف المنشور بنجاح');
    }
}
