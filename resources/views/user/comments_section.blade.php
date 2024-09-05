@includewhen(!count($contents->comments) ,'alerts.empty', ['msg'=>'لا توجد أي تعليقات بعد'])

<div class="commentBody">
    @foreach($contents->comments as $comment)
        <div class="card mt-5 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <img src="{{$comment->user->profile_photo_url}}" style="width: 75px;height: 75px;"/>
                    </div>
                    <div class="col-10">
                        @can('delete-post', $comment)
                            <form method="POST" action="{{ route('comment.destroy', $comment->id) }}" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف التعليق هذا؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="float-left">
                                    <i class="far fa-trash-alt text-danger fa-lg"></i>
                                </button>
                            </form>
                        @endcan
                    
                        <p class="my-1">
                            <strong>
                                {{$comment->user->name}}
                            </strong>
                            <span class="small">
                                <i class="far fa-clock"></i> <span class="comment_date text-secondary">{{$comment->created_at->diffForHumans()}}</span>
                            </span>
                        </p> 
                        
                        <a href="{{ route('post.show', $comment->Post->slug) }}#comments"><p class="mt-0 text-black">{{\Illuminate\Support\Str::limit($comment->body , 250) }}</p></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>