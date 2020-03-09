@extends('layout')
@section('content')
    <h1>Contact</h1>
    <p>This is the contact page</p> 

    {{-- تصريح بعد ظهور المعلومات التالية إلا لمن لديه البوابة الممررة إلى مكون الكان
        اسم البوابة موجود في ملف AuthServiceProvider --}}
    @can('home1.secret')
    <a href="{{ route('secret') }}">
        <h3>Admin Only</h3>
    </a>
        <p>Special contact details</p>
    @endcan
@endsection
   
