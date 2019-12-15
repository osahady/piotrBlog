<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Font-awsome -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    
    
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3">
          <h5 class="my-0 mr-md-auto font-weight-normal">Laravel Blog</h5>
            <nav class="my-2 my-md-0 mr-md-3">  
                <a class="p-2 text-dark" href="{{ route('home1') }}">Home</a>
                <a class="p-2 text-dark" href="{{ route('contact') }}">Contact</a>
                <a class="p-2 text-dark" href="{{ route('posts.index') }}">Blog Posts</a>
                <a class="p-2 text-dark" href="{{ route('posts.create') }}">Create a Post</a>
            </nav>
    
        </div>
        <hr>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Nice!</strong> {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->has('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Nice!</strong> {{ session()->get('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div> 
      
        @endif

        @yield('content')

    </div>
    








    {{-- <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>