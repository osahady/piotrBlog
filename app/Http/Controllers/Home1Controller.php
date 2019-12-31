<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Home1Controller extends Controller
{
    //
    public function home()
    {
        // dd(Auth::id());
        // dd(Auth::user());
        // dd(Auth::check());
        return view('home1');
        
    }

    public function contact()
    {
        return view('contact');
    }

    public function secret()
    {
        return view('secret');
    }
}
