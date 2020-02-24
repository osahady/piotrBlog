
@forelse ($comments as $comment)
<div class="media mb-5">
    <i class="fa fa-user fa-2x mr-3 mt-2 bg-secondary rounded p-2"></i>
    <div class="media-body">            
        {{-- <small class="text-muted">
            added {{ $comment->created_at->diffForHumans() }}
        </small> --}}
        @updated(['date' => $comment->created_at, 'name' => $comment->user->name, 'userId'=>$comment->user->id])
                        {{--what ever here is shown as a value to slot variable  --}}
                        <i class="far fa-clock mr-2"></i>
        @endupdated
        <div>{{ $comment->content }}</div>
    </div>
</div> 
@empty
    <p>No comments yet! </p>
@endforelse