
@extends('layout')
@section('content')
    <h1>{{ __('messages.welcome') }} </h1>

    <p>
        {{ __('messages.example_with_value', ['name'=>'جمال']) }}
    </p>
    <p>
        {{ trans_choice('messages.plural', 0) }}
    </p>
    <p>
        {{ trans_choice('messages.plural', 1) }}
    </p>
    <p>
        {{ trans_choice('messages.plural', 2) }}
    </p>
    <p>
        {{ trans_choice('messages.plural', 3) }}
    </p>

    <p>
        using json: {{ __('Welcome to Laravel!') }}
    </p>
    <p>
        using json: {{ __('Hello :name', ['name'=>'جمال']) }}
    </p>
    <p>This is the content of the main page!</p>
@endsection
   
