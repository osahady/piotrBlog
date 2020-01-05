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
        
        <div class="card border-success mb-3">
            <div class="card-header">
                <h3>{{ Str::words($post->title, 3) }}</h3>
                    
            </div>
            
            <div class="card-body" >                    
                <h4><a class="card-title" href="{{ route('posts.show', ['post' => $post->id]) }}">
                    {{ $post->title }}</a></h4>
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
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <small><i class="far fa-clock mr-2"></i>{{ $post->created_at->diffForHumans() }}</small>
                        <small> &nbsp; By: {{ $post->user->name }}</small>

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
        <div class="card">
           
            <div class="card-body">
                <h5 class="card-title">Most Commented</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    What People are currently talking about?
                </h6>
                <ul class="list-group">
                    @foreach ($mostCommented as $topPost)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', $topPost->id) }}" >

                            {{ $topPost->title }}
                        </a>
                    </li>
                        
                    @endforeach
                </ul>
                
            </div>
        </div>        
    </div>
</div>

    <div class="d-flex justify-content-center">
        <div>

            {{$posts->render()}}
        </div>
    </div>
@endsection