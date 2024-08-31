@extends('layouts.main')

@section('content')
  <div class="col-md-12">
    <p class="h4 my-4">
      {{$title}}
    </p>
  </div>

  <div class="col-md-8">
    
    @includeWhen(count($posts) === 0, 'alerts.empty', ['msg' => 'لا توجد منشورات'])

    @foreach($posts as $post)
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <img src="{{$post->user->profile_photo_url}}" alt="" style="float: right" class="rounded-full" width="50px">
              <p class="mt-2 me-3" style="display: inline-block"><strong>{{$post->user->name}}</strong></p>
              <div class="row mt-2">
                <div class="col-3">
                  <i class="far fa-clock"></i> <span class="text-secondary">{{$post->created_at->diffForHumans()}}</span>
                </div>
                <div class="col-3">
                  <i class="fa-solid fa-align-justify"> <a class="text-secondary" href="{{route('posts_by_category', [$post->category->id, $post->category->slug])}}">{{$post->category->title}}</a></i>
                </div>
                <div class="col-3">
                  <i class="fa-solid fa-comment"></i> <span class="text-secondary">{{$post->comments->count()}} تعليقات</span>
                </div>
              </div>
              <h4 class="h4 my-2">
                <a href="{{route('post.show', $post->slug)}}">
                  {{$post->title}}
                </a>
              </h4>
              
              <p class="card-text mb-2">{!! Str::limit($post->body, 200) !!}</p>
            
            </div>
          </div>
        </div>
      </div>
    @endforeach

    <ul class="pagination justify-content-center mb-4">
      {{$posts->links()}}
    </ul>
  </div>
  @include('partials.sidebar')
@endsection