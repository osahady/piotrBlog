@extends('layout')

@section('content')
    {{-- @foreach ($posts as $post)
        <p> 
            <h3>{{ $post->title }}</h3>
        </p>
    @endforeach --}}
<div class="row">
    <div class="col-8">
        @forelse ($posts as $post)
        
        <div class="card {{ $post->trashed() ? 'border-warning' : 'border-success' }} mb-3">
            <div class="card-header {{ $post->trashed() ? 'bg-danger' : '' }}">
                <h3>
                    @if ($post->trashed())
                        <del>
                    @endif
                    {{ Str::words($post->title, 3) }}
                    @if ($post->trashed())
                        </del>
                    @endif
                </h3>
                    
            </div>
            
            <div class="card-body" >                    
                <h4>
                    @if ($post->trashed())
                        <del>
                    @endif
                    <a class="card-title {{ $post->trashed()? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">
                    {{ $post->title }}</a>
                    @if ($post->trashed())
                        </del>
                    @endif
                </h4>
                    <p class="lead card-text">
                        {{ Str::limit($post->content, 20) }}
                    </p>
                    <div class="row">
                        <div class="col-sm-6">
                            @can('update', $post)
                            <a class="btn btn-block btn-outline-primary" 
                            href="{{ route('posts.edit', ['post'=>$post->id]) }}">
                            Edit
                        </a>       
                        @endcan
                        
                        
                    </div>
                    <div class="col-sm-6">
                        @if (!$post->trashed())
                            
                        @can('delete', $post)                                  
                        
                        <form action="{{ route('posts.destroy', ['post'=>$post->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-block" type="submit">Delete</button>
                                </form>
                                @endcan
                                @cannot('delete', $post)                                
                                <button class="btn btn-outline-dark btn-block" disabled>Delete</button>                                
                            @endcannot
                        @endif

                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        {{-- <small><i class="far fa-clock mr-2"></i>{{ $post->created_at->diffForHumans() }}</small>
                        <small> &nbsp; By: {{ $post->user->name }}</small> --}}

                        @updated(['date' => $post->created_at, 'name' => $post->user->name])
                            {{--what ever here is shown as a value to slot variable  --}}
                            <i class="far fa-clock mr-2"></i>
                        @endupdated

                        @if ($post->comments_count)
                        <small class="ml-auto"><i class="fas fa-comment mr-1"></i>{{ $post->comments_count }}</small>
                        
                        @else   
                            <small class="ml-auto"><i class="fas fa-comment mr-1"></i>no comments</small>
                            @endif
                        </div>
                    </div>
            </div>
                    
           
        @empty
        <p>No blog posts yet!</p>
        @endforelse
                    
                    
    </div>
            
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
                
    </div>
</div>

    <div class="d-flex justify-content-center">
        <div>

            {{$posts->render()}}
        </div>
    </div>
@endsection