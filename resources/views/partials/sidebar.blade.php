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
</div>