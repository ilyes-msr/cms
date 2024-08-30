@foreach($roles as $role)
  <option value="{{$role->id}}">{{$role->title}}</option>
@endforeach