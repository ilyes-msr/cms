@extends('admin.theme.default')

@section('title', 'الصفحات الإضافية')

@section('content')

    <div class="container-fluid">
        <div class="card mb-3">
          <div class="card-header">
            <a href="{{route('pages.create')}}" class="btn btn-outline-secondary">إضافة صفحة جديدة</a>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>الرابط</th>
                          <th>العنوان</th>
                          <th>تاريخ الإنشاء</th>
                          <th>تعديل</th>
                          <th>حذف</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($pages as $page)
                            <tr>
                              <td>{{$page->slug}}</td>
                              <td>{{ $page->title }}</td>
                              <td>{{$page->created_at}}</td>
                              <td>
                                  <form method="GET" action="{{ route('pages.edit', $page->id) }}">
                                      @csrf
                                      @method('PATCH')
                                      <button type="submit" class="btn btn-link" style="background-color: white;border: none;"><i class="far fa-edit text-success fa-lg"></i></button>
                                  </form>

                              </td>
                              <td>
                                  <form method="POST" action="{{ route('pages.destroy', $page->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link" style="background-color: white;border: none;"><i class="far fa-trash-alt text-danger fa-lg"></i></button>       
                                  </form>

                              </td>
                            </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
    </div>
 
@endsection