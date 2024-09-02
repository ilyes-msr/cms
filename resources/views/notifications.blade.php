@extends('layouts.main')

@section('content')
<h1 class="text-xl my-3 font-bold">جميع الإشعارات</h1>
<ul class="list-group">
  @forelse($notifications as $notification)
    <li class="list-group-item">
      <a class="dropdown-item d-flex align-items-center" href="{{route('post.show', $notification->post->slug)}}">
        <div class="ml-3">
          <div>
            <img style="float:right; width:40px; height:40px; object-fit:cover" src="{{$notification->user->profile_photo_url}}" width="50px" class="rounded-full">
          </div>
        </div>
        <div>
          <div class="small text-gray-500">{{$notification->created_at->diffForHumans()}}</div>
            <span>
              {{$notification->user->name}} وضع تعليقًا على المنشور <b>{{$notification->post->title}}
              <b></b></b>
            </span>
            <b><b></b></b>
          </div>
          <b><b></b></b>
      </a>

    </li>
  @empty
    <li>لا إشعارات حالياً</li>
  @endforelse
</ul>
@endsection