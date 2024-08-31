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

    <div class="py-3 my-3">
      <h2 class="text-xl mb-3">التعليقات</h2>
      <ul class="list-group">
  
        @forelse($post->comments as $comment)
          
          <li class="list-group-item d-flex justify-content-between align-items-end">
  
            <img src="{{asset('/storage/' . $comment->user->profile_photo_path)}}" alt="" style="border-radius: 50%; width: 50px; height: 50px; object-fit: cover">
            <div class="ms-auto me-2">
              <div class="fw-bold">{{$comment->user->name}}</div>
              {{$comment->body}}
            </div>
          </li>
        @empty
        <li>
          لا توجد تعليقات لحدّ الآن
        </li>
        @endforelse
      </ul>
  
      @auth
      <h2 class="my-3 text-lg font-bold">أضف تعليقا</h2>
      <form id="add-comment-form">
        <div class="mb-3">
          <input type="text" class="form-control" id="body" name="body">
          <div id="" class="form-text">يمكنك التعليق وسيظهر في الصفحة حال الموافقة عليه</div>
        </div>
        <input type="hidden" name="post_id" value="{{$post->id}}" id="post_id">
        <button type="submit" class="btn btn-outline-secondary">إضافة</button>
      </form>
      @endauth  
    </div>
  </div>
  @include('partials.sidebar')
@endsection

@section('script')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      
    const form = document.getElementById('add-comment-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(form);

        try {
            const response = await fetch('/comments', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData,
            });

            if (response.ok) {
                const data = await response.json();
                console.log('Success:', data);
                // Optionally update the UI with the new comment
            } else {
                const errorData = await response.json();
                console.error('Error:', errorData.errors);
                // Handle validation errors, e.g., display them on the form
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
  });

  </script>
@endsection