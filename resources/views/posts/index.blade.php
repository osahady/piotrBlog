@extends('layout')

@section('content')
    {{-- @foreach ($posts as $post)
        <p> 
            <h3>{{ $post->title }}</h3>
        </p>
    @endforeach --}}

    @forelse ($posts as $post)
        <p>
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                {{ $post->title }}
            </a>
            </h3>
        </p>
    @empty
        <p>No blog posts yet!</p>
    @endforelse
@endsection