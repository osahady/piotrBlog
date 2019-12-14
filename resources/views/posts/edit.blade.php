@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form action="{{ route('posts.update', ['post'=>$post->id]) }} " method="POST" >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}"
            </div>
    
            <div class="form-group mt-3">
                
                <label for="title">Content</label>
                <textarea class="form-control" name="content" cols="30" rows="4" >{{ Request::old('content', $post->content) }}</textarea>
            </div> 
            <div class="form-group my-4">
                <button class="btn btn-primary btn-block" type="submit">Update!</button>
                 
            </div> 
            @if ($errors->any())
                <div class="form-group alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>     
                        @endforeach
                    </ul>
                </div>
            @endif      
        </form>   
    </div>
</div>
     
@endsection
