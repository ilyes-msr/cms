@extends('layouts.main')

@section('style')
  <style>
    .post-img {
      text-align: justify;
      max-width: 600px;
      max-height: 600px;
    }
    li {
      list-style: none
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
      @auth
      <h2 class="my-3 text-lg font-bold">أضف تعليقا</h2>
      <form id="add-comment-form">
        <div class="mb-3">
          <textarea name="body" id="body" class="form-control" rows="3" placeholder="يمكنك كتابة تعليقك هنا"></textarea>
        </div>
        <input type="hidden" name="post_id" value="{{$post->id}}" id="post_id">
        <button type="submit" class="btn btn-outline-secondary">تعليق

          <span class="spinner-border spinner-border-sm" aria-hidden="true" id="spinner" style="display: none"></span>
        </button>
      </form>
      @endauth  

      <h2 class="text-xl my-3">التعليقات</h2>
      <ul class="list-group">
        @include('comments.all', ['comments' => $comments, 'post_id' => $post->id])
      </ul>  
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

@section('script')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
    const spinner = document.querySelector('#spinner');
    const comment = document.querySelector('#body');
    const form = document.getElementById('add-comment-form');
    const replyForm = document.getElementById('add-reply-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        spinner.style.display = 'inline-block';  

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
                spinner.style.display = 'none';  
                comment.value = '';
                const toastLiveExample = document.getElementById('liveToast')
                const toast = new bootstrap.Toast(toastLiveExample)
                toast.show()
                
                // console.log('Success:', data);
                // Optionally update the UI with the new comment

            } else {
                const errorData = await response.json();
                // console.error('Error:', errorData.errors);

                spinner.style.display = 'none';  

                const toastLiveExample = document.getElementById('liveToastError')
                const toast = new bootstrap.Toast(toastLiveExample)
                toast.show()
                // Handle validation errors, e.g., display them on the form
            }
        } catch (error) {
            // console.error('Error:', error);
        }
    });


  });

  </script>

  <script>
    const submitReplyFormButtons = document.querySelectorAll('.submit-reply-form-button');
    const replyButtons = document.querySelectorAll('.reply-button');

    replyButtons.forEach(button => {
      button.addEventListener('click', (event) => {
        // console.log(event.target.parentElement.id)
        const idParts = event.target.parentElement.id.split('-');
        const buttonId = idParts.pop();
        console.log(buttonId);
        const replyFormTargeted = document.querySelector(`#add-reply-form-container-${buttonId}`);
        replyFormTargeted.style.display = replyFormTargeted.style.display == "none" ? "block" : "none";
      
      })
    })

    submitReplyFormButtons.forEach(element => {
      element.addEventListener('click', (e) => {
        const parts = e.target.id.split('-');
        const commentId = parts.pop();
        const replyInput = document.querySelector(`#reply-to-${commentId}`);
        const reply = document.querySelector(`#reply-to-${commentId}`).value;
        const postId = document.querySelector(`#post-id-${commentId}`).value;

        const replySpinner = document.querySelector(`#reply-spinner-${commentId}`);
        replySpinner.style.display = "inline-block";
  $.ajax({
            url: '/comments/reply',
            type: 'POST',
            data: JSON.stringify({
              "comment_id": commentId,
              "post_id": postId,
              "reply": reply
            }),
            contentType: 'application/json',
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
              replySpinner.style.display = "none";

                console.log('Success:', response);
                // Optionally update the UI with the new comment
                replyInput.value = "";
                const toastLiveExample = document.getElementById('liveToast')
                const toast = new bootstrap.Toast(toastLiveExample)
                toast.show()

            },
            error: function(xhr) {
              replySpinner.style.display = "none";

              const toastLiveExample = document.getElementById('liveToastError')
              const toast = new bootstrap.Toast(toastLiveExample)
              toast.show()

                if (xhr.status === 422) { // 422 Unprocessable Entity (validation error)
                    const errors = xhr.responseJSON.errors;
                    const errorDiv = $('#error-messages');
                    errorDiv.empty(); // Clear previous errors
                    $.each(errors, function(key, messages) {
                        $.each(messages, function(index, message) {
                            errorDiv.append('<p>' + message + '</p>');
                        });
                    });
                } else {
                    console.error('Error:', xhr.responseText);
                }
            }
        });
  });

  })
</script>
@endsection