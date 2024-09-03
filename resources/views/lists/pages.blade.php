@foreach($pages as $page)
<li>
  <a class="dropdown-item" href="{{ route('pages.show', $page->slug)}}">
    {{$page->title}}
  </a>
</li>

  <option value=""></option>
@endforeach