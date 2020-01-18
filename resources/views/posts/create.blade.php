@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form action="{{ route('posts.store') }} " method="POST" >
            @csrf
            @include('posts._form')
            <div class="form-group my-4">
                <button class="btn btn-primary btn-block" type="submit">Create!</button>
                    
            </div>       
        </form>   
    </div>
</div>
     
@endsection
