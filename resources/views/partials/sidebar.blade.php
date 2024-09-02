<div class="col-md-4">
  <div class="card">
    <h5 class="card-header">التصنيفات</h5>
    <div class="card-body">
      <ul class="nav flex-column p-0">
          <li class="nav-item">
            <a href="{{url('/')}}" class="nav-link">جميع التصنيفات {{ $posts_number }}</a>
          </li>
          @foreach ($categories as $category)
              <li class="nav-item">
                <a href="{{route('posts_by_category', [$category->id, $category->slug])}}" class="nav-link text-dark">{{$category->title}} {{$category->posts->where('approved', 1)->count()}}</a>
              </li>
          @endforeach
        </ul>
    </div>
  </div>

      <!-- Side Widget -->
      <div class="card my-4 text-right">
        <h5 class="card-header">آخر التعليقات</h5>
        <ul class="list-group p-0">
            @foreach($recent_comments as $comment)
                <li class="list-group-item">
                    <a href="{{ route('post.show', $comment->Post->slug) }}#comments">
                        <img style="float:right; width: 40px; height: 40px; object-fit: cover" src="{{$comment->user->profile_photo_url}}" class="rounded-full"/>
                        <span class="mt-1 me-1 d-inline-block"><strong>{{$comment->user->name}}</strong></span> 
                        <span>{{\Illuminate\Support\Str::limit($comment->body, 60) }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>