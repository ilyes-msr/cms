@extends('admin.theme.default')

@section('title')
         الأدوار
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> إضافة الأدوار
                <form method="post" action="{{ route('roles.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control @error('role') is-invalid @enderror" name="role" placeholder="الدور">
                            @error('role')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col">
                            <button type="submit" class="btn btn-dark">حفظ </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>الدور</th>
                        <th>تاريخ الإنشاء</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->role }}</td>
                        <td>{{ $role->created_at }}</td>
                        <td>
                        <form method="post" action="{{ route('roles.destroy', $role->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link" style="background-color: white;border: none;"><i class="far fa-trash-alt text-danger fa-lg"></i> </button>       
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