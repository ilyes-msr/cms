@foreach($comments as $comment) 
  <li class="list-group-item">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <img src="{{asset('/storage/' . $comment->user->profile_photo_path)}}" alt="" style="border-radius: 50%; width: 50px; height: 50px; object-fit: cover">
    <div class="ms-auto me-2">
      <div class="fw-bold">{{$comment->user->name}}</div>
      {{$comment->body}}
      <br>
      <span class="cursor-pointer reply-button text-sm" id="reply-button-{{$comment->id}}">
        <i class="fa-solid fa-reply text-secondary"></i>
        <span class="text-secondary">{{__('site.add_reply')}}</span>
      </span>
    </div>
    <span class="text-muted text-sm">{{$comment->created_at->diffForHumans()}}</span>
    </div>
    <div class="" style="display: none" id="add-reply-form-container-{{$comment->id}}">
      <form id="add-reply-form-to-{{$comment->id}}">
        <div class="mb-3">
          <textarea name="reply" id="reply-to-{{$comment->id}}" rows="2" class="form-control" required></textarea>
        </div>
        <input type="hidden" name="post_id" value="{{$post->id}}" id="post-id-{{$comment->id}}">
        <input type="hidden" name="comment_id" value="{{$comment->id}}" id="comment-id-{{$comment->id}}">
        <button type="button" class="btn btn-dark btn-sm submit-reply-form-button" id="submit-form-to-{{$comment->id}}">إضافة           <span class="spinner-border spinner-border-sm" aria-hidden="true" id="reply-spinner-{{$comment->id}}" style="display: none"></span></button>
      </form>
 
    </div>
    @if($comment->replies->count() > 0)
    <ul class="inside pr-5">
        @include('comments.all', ['comments' => $comment->replies, 'post_id' => $post->id])
    </ul>
  @endif 
  </li>
@endforeach