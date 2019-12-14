<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">



    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    
    
    <title>Document</title>
</head>
<body>
    <div class="container">
        <ul class="list-group list-group-horizontal justify-content-center my-3">
            <li class="list-group-item"><a href="{{ route('home1') }}">Home</a></li>
            <li class="list-group-item"><a href="{{ route('contact') }}">Contact</a></li>
            <li class="list-group-item"><a href="{{ route('posts.index') }}">Blog Posts</a></li>
            <li class="list-group-item"><a href="{{ route('posts.create') }}">Create a Post</a></li>
    
    
        </ul>
        <hr>

        @if (session()->has('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Nice!</strong> {{ session()->get('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @yield('content')

    </div>
    








    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>