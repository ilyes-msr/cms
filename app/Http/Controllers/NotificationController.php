<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Notification::where('post_userId', auth()->id())->with('post', 'user')->latest()->get();
        return view('notifications', compact('notifications'));
    }

    public function getNotifications(Request $request)
    {
        $user_id = $request->get('user_id');
        $notifications = Notification::where('post_userId', $user_id)->latest()->take(10)->get();
        $data = [];
        foreach ($notifications as $notification) {
            $single_notification = array();
            $user = User::find($notification->user_id);
            $post = Post::find($notification->post_id);

            $single_notification['user_image'] = $user->profile_photo_url;
            $single_notification['user_name'] = $user->name;
            $single_notification['post_title'] = $post->title;
            $single_notification['post_slug'] = $post->slug;
            $single_notification['created_at'] = $notification->created_at->diffForHumans();

            array_push($data, $single_notification);
        }

        $alert = Alert::where('user_id', auth()->id())->first();
        $alert->alert = 0;
        $alert->save();

        return json_encode(['notifications' => $data]);
    }
}
