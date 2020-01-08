@extends('layout')

@section('content')
    <h3>
        {{ $post->title }}
        {{--boot function تم تعريف المكون في ملف AppServiceProvider --}}
        {{--  Blade::component('components.badge', 'badge'); --}}
        @badge(['show' => now()->diffInMinutes($post->created_at) < 30])
            Brand New Post!
        @endbadge   
    
         
    
    </h3>
    <p>{{ $post->content }}</p>

    {{-- <small>Add at {{ $post->created_at->diffForHumans() }}</small>  --}}

    @updated(['date' => $post->created_at, 'name' => $post->user->name])
                            {{--what ever here is shown as a value to slot variable  --}}
                            <i class="far fa-clock mr-2"></i>
    @endupdated

    @updated(['date' => $post->updated_at])
        updated
    @endupdated



    <h4>Comments</h4>

    @forelse ($post->comments as $comment)
    <div class="media mb-5">
        <i class="fa fa-user fa-2x mr-3 mt-2 bg-secondary rounded p-2"></i>
         <div class="media-body">            
             {{-- <small class="text-muted">
                 added {{ $comment->created_at->diffForHumans() }}
             </small> --}}
             @updated(['date' => $post->created_at])
                            {{--what ever here is shown as a value to slot variable  --}}
                            <i class="far fa-clock mr-2"></i>
             @endupdated
             <div>{{ $comment->content }}</div>
         </div>
     </div> 
    @empty
        <p>No comments yet! </p>
    @endforelse

    
@endsection