<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Comment;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // DB::connection()->enableQueryLog();
        // $posts = BlogPost::with('comments')->get();
        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        $posts = BlogPost::withCount('comments')->paginate(15);
        // dd(DB::getQueryLog());
        
        return view('posts.index', compact('posts') );
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

       return redirect()->route('posts.show', ['post'=>$bp->id])->with('success', 'Blog Post was created!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // $request->session()->reflash();
        return view('posts.show', ['post'=> BlogPost::with('comments')->findOrFail($id)]);
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
        $post = BlogPost::findOrFail($id);
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit the post");
        // }
        $this->authorize('posts.update', $post);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        //
        $post = BlogPost::findOrFail($id);
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't update the post");
        // }
        $this->authorize('posts.update', $post);

        $vd = $request->validated();
        $post->fill($vd);

        $post->save();
        return redirect()->route('posts.show', ['post'=>$post->id])->with('success', 'Blog post was updated!');
        // $request->session()->flash('status', 'Blog post was updated!');
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
        $post = BlogPost::findOrFail($id);
        // if(Gate::denies('delete-post', $post)){
        //     abort(403, 'You can not delete the post');
        // }
        $this->authorize('posts.delete', $post);
        $post->delete();

        // BlogPost::destroy($id);
        return redirect()->route('posts.index')->with('danger', 'The post has been deleted!');
    }
}
