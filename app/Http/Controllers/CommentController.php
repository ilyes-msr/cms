<?php

namespace App\Http\Controllers;

use App\Events\CommentNotification;
use App\Models\Alert;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;

class CommentController extends Controller
{
    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $comment = Comment::create([
            'body' => $request->input('body'),
            'post_id' => $request->input('post_id'),
            'user_id' => auth()->id(),
            'commentable_type' => 'App\Models\Post',
            'commentable_id' => $request->input('post_id')
        ]);
        $post = Post::find($request->input('post_id'));
        if ($request->user()->id != $post->user_id) {
            // create notif
            $notification = new Notification();
            $notification->user_id = $request->user()->id;
            $notification->post_id = $post->id;
            $notification->post_userId = $post->user_id;

            // store notif
            $notification->save();

            // send notif
            $data = [
                'post_title' => $post->title,
                'post' => $post,
                'user_name' => auth()->user()->name,
                'user_image' => auth()->user()->profile_photo_url
            ];
            event(new CommentNotification($data));

            $alert = Alert::where('user_id', $post->user_id)->first();
            $alert->alert++;
            $alert->save();
        }

        return response()->json(['success' => true, 'comment' => $comment], 201);
    }

    public function storeReply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reply' => 'required',
            'post_id' => 'required|exists:posts,id',
            'comment_id' => 'required|exists:comments,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $reply = Comment::create([
            'body' => $request->input('reply'),
            'post_id' => $request->input('post_id'),
            'user_id' => auth()->id(),
            'parent_id' => $request->input('comment_id'),
            'commentable_type' => 'App\Models\Comment',
            'commentable_id' => $request->input('comment_id')
        ]);
        return response()->json(['success' => true, 'reply' => $reply], 201);
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return back()->with('success', 'تم الحذف بنجاح');
    }
}
