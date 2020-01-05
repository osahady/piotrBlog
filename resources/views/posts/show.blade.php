@extends('layout')

@section('content')
    <h3>{{ $post->title }}</h3>
    <p>{{ $post->content }}</p>

    <small>Add at {{ $post->created_at->diffForHumans() }}</small>

    @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 20 )
    {{-- تم تعريف المكون في ملف AppServiceProvider --}}
        @badge
            Brand New Post!
        @endbadge
    @else
    <strong> old </strong>

    @endif

    <h4>Comments</h4>

    @forelse ($post->comments as $comment)
    <div class="media mb-5">
        <i class="fa fa-user fa-2x mr-3 mt-2 bg-secondary rounded p-2"></i>
         <div class="media-body">            
             <small class="text-muted">
                 added {{ $comment->created_at->diffForHumans() }}
             </small>
             <div>{{ $comment->content }}</div>
         </div>
     </div> 
    @empty
        <p>No comments yet! </p>
    @endforelse

    
@endsection