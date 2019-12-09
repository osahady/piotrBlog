<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home1Controller extends Controller
{
    //
    public function home()
    {
        return view('home1');
    }

    public function contact()
    {
        return view('contact');
    }

    public function blogPost($id, $welcome = 1)
    {
        
        $pages = [
            1 => [
                'title' => ' from page 1',
            ],
    
            2 => [
                'title' => ' from page 2',
            ]
        ];
    
        $welcomes = [ 1 => 'Hello', 2 => 'Welcome '];
    
        return view('blog-post', ['x'     => $pages[$id], 
                                  'y'     => $welcomes[$welcome]
        ]);
    }
}
