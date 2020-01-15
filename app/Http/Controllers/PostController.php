<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        

        //هذا يسمى النطاق المحلي 
        //local query scope
        //orderBy('created_at', 'desc')
        // $posts = BlogPost::withCount('comments')->orderBy('created_at', 'desc' )->paginate(15);
        //تمت الاستعاضة عن النطاق المحلي بالنطاق العالمي
        //global query scope
        //وذلك بتطبيق الاتفاقية في صف LatestScope
        //وتسجيل النطاق العالمي في تابع الإقلاع
        //الخاص بنموذج الجدول عبر التعليمة التالية
        // static::addGlobalScope(new LatestScope);

        //استدعاء المستخدمين سيخزن البيانات في الكاش
        $posts = BlogPost::latest()->withCount('comments')->with('user')->with('tags')->get();
        // $mostCommented = BlogPost::mostCommented()->take(5)->get();
        //أسلوب التخزين المؤقت يعتمد على المفتاح والقيمة
        // المفتاح هنا هو المعامل الأول للتابع تذكر
        // حيث يقوم الكاش بتفحص المفتاح أولا فإن وجد البيانات
        //وإلا قام باستدعاء التابع المجهول 
        // الذي بدوره يستدعي التعليمة التي تقوم بالتخاطب مع قاعدة البيانات

        //تم إلغاء الاستعلامات من هنا وإضافتها إلى ما يسمى
        //composer view -> AppServiceProvider

        // dd(DB::getQueryLog());
        return view('posts.index', 
                    compact('posts') 
                );
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
        // $this->authorize(BlogPost::find($id));//هذا يستدعي مزود التوثيق  الذي يستدعي سياسة المنشورات

        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 600, function() use ($id){
            return BlogPost::with('comments')->with('tags')->with('user')->findOrFail($id);
        });
        //هذه إحدى طرق استدعاء الاستعلام المحلي في لارافيل
        // وهناك طريقة أخرى أسهل منها وهي استدعاء الاستعلام المحلي
        // في صف المنشور مباشرة عند إنشاء العلاقة
        // return view('posts.show', ['post'=> BlogPost::with(['comments'=> function($query){
        //     $query->latest();
        // }])->findOrFail($id)]);

        /* 
        my code
        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";
        //سيتم إحضار مفتاح المستخدمين من الكاش 
        // وفي حال عدم وجود هذا المفتاح سيعيد مصفوفة فارغة
        $users = Cache::get($usersKey, []);
        $usersUpdate = [];
        $diffrence = 0;
        $now = now();
        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1) {
                $diffrence--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }            
        }//end of foreach looping users
        if (
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
        ) {
            $diffrence++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::forever($usersKey, $usersUpdate);

        if(!Cache::has($counterKey)){
            Cache::forever($counterKey, 1);
        }else{

            Cache::increment($counterKey, $diffrence);
        }
        $counter = Cache::get($counterKey);
        echo $sessionId . '<br>'. 
             $counterKey . '<br>' . 
             $usersKey . '<br>' . 
             $diffrence . '<br>' .
             $now . '<br>';
        
        // dd($users, $usersUpdate);
        return view('posts.show', [
            'post'=> $blogPost,
            'counter' => $counter,
        ]);
        */

        //pioter code
        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";
        $users = Cache::tags(['blog-post'])->get($usersKey, []);
        $usersUpdate = [];
        $diffrence = 0;
        $now = now();
        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 60) {
                $diffrence++;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }//end looping users foreach
        if(
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 60
        ) {
            $diffrence++;
        }
        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);
        if (!Cache::tags(['blog-post'])->has($counterKey)) {
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog-post'])->increment($counterKey, $diffrence);
        }
        
        $counter = Cache::tags(['blog-post'])->get($counterKey);
        return view('posts.show', [
            'post' => $blogPost,
            'counter' => $counter,
        ]);
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

        /*
        
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

        */
               
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
