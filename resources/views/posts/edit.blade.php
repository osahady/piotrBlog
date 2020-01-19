@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form action="{{ route('posts.update', ['post'=>$post->id]) }} " method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('posts._form')
            
            <div class="form-group my-4">
                <button class="btn btn-primary btn-block" type="submit">Update!</button>
                 
            </div> 
        </form>   
    </div>
</div>
     
@endsection
