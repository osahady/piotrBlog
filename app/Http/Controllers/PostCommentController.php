<?php

namespace App\Http\Controllers;

use App\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Support\Facades\Mail;

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
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        //this method invoke app\Mail\CommentPosted.php 
        // and the send member method invoke the build method 
        //inside CommentPosted instance 
        Mail::to($post->user)->send(
            new CommentPostedMarkdown($comment)
        );
        // $request->session()->flash('success', 'Commnet was created');

        return redirect()->back()->with('success', 'Comment was created');
    }
}
