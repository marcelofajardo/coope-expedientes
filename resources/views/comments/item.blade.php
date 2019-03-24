<div class="p-4 border-left my-3">
    <p class="font-weight-bold">User {{ $comment->user->name }}:</p>
    <p>{{ $comment->content }}</p>

    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#reply-{{$comment->id}}" aria-expanded="false" aria-controls="reply-{{$comment->id}}">
        Reply
    </button>

    <div class="collapse my-3" id="reply-{{$comment->id}}">
  	<div class="card card-body">
    		@include('comments.form', ['comment' => $comment])
    	</div>
    </div>

    @if ($comment->replies)
    	@include('comments.index', ['comments' => $comment->replies])
    @endif
</div>
