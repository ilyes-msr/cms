@foreach($categories as $category)
  <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
@endforeach