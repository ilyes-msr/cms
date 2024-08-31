@extends('layouts.main')

@section('style')

  <style>
    .post-img {
      text-align: justify;
      max-width: 600px;
      max-height: 600px;
    }
  </style>
  
@endsection

@section('content')
  <p class="h4 my-4">{{$post->title}}</p>
  <input type="hidden" id="postId" value="{{$post->id}}">

  <div class="col-md-8">
    <div class="bg-white p-5">

      <img src="{{$post->user->profile_photo_url}}" alt="" style="float: right" class="rounded-full" width="50px">
      <p class="mt-2 me-3" style="display: inline-block"><strong>{{$post->user->name}}</strong></p>
      <div class="row mt-2">
        <div class="col-3">
          <i class="far fa-clock"></i> <span class="text-secondary">{{$post->created_at->diffForHumans()}}</span>
        </div>
        <div class="col-3">
          <i class="fa-solid fa-align-justify"> <span class="text-secondary">{{$post->category->title}}</span></i>
        </div>
        <div class="col-3">
          <i class="fa-solid fa-comment"></i> <span class="text-secondary">{{$post->comments->count()}} تعليقات</span>
        </div>
      </div>

      @if(file_exists(public_path('/storage/' . $post->img_path)))
        <img src="{{asset('/storage/' . $post->img_path)}}" alt="" class="mb-4 mx-auto post-img">
      @endif

      <p class="lh-lg">{!! $post->body !!}</p>
    </div>
  </div>
  @include('partials.sidebar')
@endsection

