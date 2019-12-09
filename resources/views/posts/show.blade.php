@extends('layout')

@section('content')
    <h3>{{ $post->title }}</h3>
    <p>{{ $post->content }}</p>

    <small>Add at {{ $post->created_at->diffForHumans() }}</small>

    @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5 )
        <strong> New! </strong>
    @else
    <strong> old </strong>

    @endif
@endsection