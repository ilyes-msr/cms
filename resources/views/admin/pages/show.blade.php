@extends('layouts.main')

@section('content')
  <p class="h4 my-4">{{$page->title}}</p>

  <div class="col-md-8">
    <div class="bg-white p-5">
      <div class="row mt-2">
      </div>
      <p class="lh-lg">{!! $page->content !!}</p>
    </div>

  </div>

  @include('partials.sidebar')


  <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" id="liveToast" style="position: fixed; top: 10px; right: 10;">
    <div class="d-flex">
      <div class="toast-body">
        تمّ إرسال التعليق بنجاح، وسيظهر عند الموافقة عليه
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

  <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" id="liveToastError" style="position: fixed; top: 10px; left: 10px;">
    <div class="d-flex">
      <div class="toast-body">
        حدث خطأ ما.. تأكّد من البيانات المدخلة أو أعد المحاولة لاحقاً
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
@endsection
