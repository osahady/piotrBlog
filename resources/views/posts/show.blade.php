@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">

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
        @tags(['tags' => $post->tags])@endtags

        <p>Currently read by <strong> {{ $counter }} </strong>  people </p>

        <h4>Comments</h4>

        @forelse ($post->comments as $comment)
        <div class="media mb-5">
            <i class="fa fa-user fa-2x mr-3 mt-2 bg-secondary rounded p-2"></i>
            <div class="media-body">            
                {{-- <small class="text-muted">
                    added {{ $comment->created_at->diffForHumans() }}
                </small> --}}
                @updated(['date' => $comment->created_at, 'name' => $comment->user->name])
                                {{--what ever here is shown as a value to slot variable  --}}
                                <i class="far fa-clock mr-2"></i>
                @endupdated
                <div>{{ $comment->content }}</div>
            </div>
        </div> 
        @empty
            <p>No comments yet! </p>
        @endforelse

    </div><!-- .col-8 -->
    <div class="col-4">
        {{-- most active posts (having most comments) --}}
         @card(['title' => 'Most Commented'])
         @slot('subtitle')
             What People are currently talking about?                
         @endslot
         @slot('items')
             @foreach ($mostCommented as $topPost)
                 <li class="list-group-item">
                     <a href="{{ route('posts.show', $topPost->id) }}" >

                         {{ $topPost->title }}
                     </a>
                 </li>                    
             @endforeach
         @endslot     
        @endcard   
    
        {{-- most active users  --}}
        @card(['title' => 'Most Active Users'])
            @slot('subtitle')
                Writters are currently talking about?
            @endslot
            @slot('items', collect($mostActive)->pluck('name'))     
        @endcard

        {{-- most active users last month --}}
        @card(['title' => 'Most Active Users Last Month'])
            @slot('subtitle')
            Active users last month
            @endslot
            @slot('items', collect($mostActiveLastMonth)->pluck('name'))        
        @endcard             
    </div><!-- .col-4 -->
</div><!-- .row -->

    
@endsection