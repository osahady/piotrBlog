@extends('layout')

@section('content')
    {{-- @foreach ($posts as $post)
        <p> 
            <h3>{{ $post->title }}</h3>
        </p>
    @endforeach --}}

    <div class="card-columns"> 
       

       
        @forelse ($posts as $post)
                      
                <div class="card border-success">
                    <div class="card-header">
                        <h3>{{ Str::limit($post->title, 9) }}</h3>
                        
                    </div>

                    <div class="card-body" >                    
                        <h4><a class="card-title" href="{{ route('posts.show', ['post' => $post->id]) }}">
                            {{ $post->title }}</a></h4>
                        <p class="lead card-text">
                            {{ Str::limit($post->content, 20) }}
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <a class="btn btn-block btn-outline-primary" href="{{ route('posts.edit', ['post'=>$post->id]) }}">Edit</a>

                            </div>
                            <div class="col-sm-6">
                                <form action="{{ route('posts.destroy', ['post'=>$post->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-block" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <div class="d-flex">
                            <small><i class="far fa-clock mr-2"></i>{{ $post->created_at->diffForHumans() }}</small>
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
@endsection