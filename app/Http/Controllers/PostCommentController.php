<?php

namespace App\Http\Controllers;

use App\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;

class PostCommentController extends Controller
{
    //هذا لزيادة الخير
    // في منظر العرض لن يتم إظهار نموذج التعليق في المرحلة الأولى من الحماية
    //وهنا حتى لو استطاع الوصول لن يكون بمقدوره التعليق لوجود الباني هذا الذي 
    //يستدعي البرمجية الوسيطة "التوثيق، المستخدم مسجل" حتى يستطيع التعليق
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }
    public function store(BlogPost $post, StoreComment $request)
    {
        $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        // $request->session()->flash('success', 'Commnet was created');

        return redirect()->back()->with('success', 'Comment was created');
    }
}
