<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('posts.index', ['posts' => BlogPost::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        //
       $vd = $request->validated();
        // dd($vd);
    //    $bp = new BlogPost();
    //    $bp->title = $request->input('title');
    //    $bp->content = $request->content;
    //    $bp->save();

    // mass assignment
    $bp = BlogPost::create($vd);

    //    $request->session()->flash('status', 'Blog Post was created!');
    //with() تقوم بإنشاء جلسة عالطاير وترسلها مع المسار إلى الصفحة المطلوبة
    //مع إرسال اسم الجلسة في المعامل الأول وقيمة الجلسة في المعامل الثاني

       return redirect()->route('posts.show', ['post'=>$bp->id])->with('status', 'Blog Post was created!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $request->session()->reflash();
        return view('posts.show', ['post'=> BlogPost::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
