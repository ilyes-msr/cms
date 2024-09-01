<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

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
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'body' => 'required',
            'post_id' => 'required|exists:posts,id', // Assuming you have a posts table 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create and save the comment
        $comment = Comment::create([
            'body' => $request->input('body'),
            'post_id' => $request->input('post_id'),
            'user_id' => auth()->id(),
            'commentable_type' => 'App\Models\Post',
            'commentable_id' => $request->input('post_id')
            // Optionally add 'user_id' if you want to link the comment to a user
        ]);


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
        //
    }
}
