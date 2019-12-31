<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Comment;
use App\Http\Requests\StorePost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    //يقوم هذا الباني البرمجية الوسيطة
    public function __construct()
    {
        //تقوم البرمجية الوسيطة بإعطاء المستخدمين المسجلين الموثوقين
        // سماحية الوصول للوظائف التالية 
        //إنشاء، تخزين، تحرير، تعديل، حذف
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
        //يعني إذا لم تكن مسجل فلن تستطيع إضافة منشور
        // أو التعديل عليه أو حتى حذفه

        //تمّ اختصار اسم البرمجية الوسيطة عن طريق ملف kernal.php
        //
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

    public function dashboard()
    {
        //جلب المستخدم المسجل حاليا في الموقع
        $user = Auth::user();
        $posts = BlogPost::withCount('comments')->where('user_id', '=', $user->id)->paginate(15);
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
        //هذه التعليمة تقوم باستدعاء
        // صلاحية الإنشاء من سياسة المنشورات 
        // $this->authorize(BlogPost::class);

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
       $vd['user_id'] = $request->user()->id;
        // dd($vd);
        //    $bp = new BlogPost();
        //    $bp->title = $request->input('title');
        //    $bp->content = $request->content;
        //    $bp->save();

        //هذه التعليمة تعطينا المستخدم المسجل حاليًّا
        // $user = Auth::user(); 
        //ويمكن الاستعاضة عنها بالتابع الموجود في الطلب الحالي
        //حيث يعطينا المستخدم المسجل حاليًّا
        // $request->user() 

        // mass assignment
        $bp = BlogPost::create($vd);
        

        // $this->authorize($bp);

        // $user->posts()->save($bp);

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
        $this->authorize(BlogPost::find($id));

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
        //هذه التعليمة لإعطاء 
        // أذونات المستخدمين بالتعديل على المنشور
        //1) if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit the post");
        // }
        // 2) $this->authorize('posts.update', $post);
        // 3) $this->authorize('update', $post);

        //هذا هو الشكل الأخير لاستدعاء
        //  تابع في سياسة المنشورات
        //تستطيع منصة اللارافيل معرفة التابع
        //من خلال تابع المتحكم الطالب للسياسة
        //يعني هنا يتم استدعاء السياسة في تابع التحرير
        // فهذا يعني استدعاء تابع التعديل في صف السياسة
        // Controller ===> Policy
        //================================
        // 'create'   ===> 'create'
        //$this->authorize(BlogPost::class);

        // 'store'    ===> 'create'
        // $this->authorize($bp);

        // 'show'     ===> 'view' === read
        // $this->authorize(BlogPost::find($id));

        // 'edit'     ===> 'update'
        // $this->authorize($post);

        // 'update'   ===> 'update' 
        // $this->authorize($post);

        // 'destroy'  ===> 'delete'
        // $this->authorize($post);
               
        $this->authorize($post);


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

        //بعد تسجيل سياسة المنشورات في مصفوفة السياسات
        // صار بإمكاننا استدعاء أي تابع ضمن صف سياسة المنشورات 
       //عن طريق اسمه بالشكل التالي
        // $this->authorize('update', $post);

        //سيتم تلقائيا تحديد التابع
        //  من خلال معرفة التابع الطالب للسياسة من المتحكم
        $this->authorize($post);

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
        // $this->authorize('posts.delete', $post);
        //طريقة مختصرة لاستدعاء السياسة
        //  فورا من دون تحديد اسم التابع
        $this->authorize($post);

        $post->delete();

        // BlogPost::destroy($id);
        return redirect()->route('posts.index')->with('danger', 'The post has been deleted!');
    }
}
