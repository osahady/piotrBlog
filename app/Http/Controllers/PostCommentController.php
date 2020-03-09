<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Events\CommentPosted;
use App\Jobs\ThrottledMail;
use App\Http\Requests\StoreComment;
use App\Mail\CommentPostedMarkdown;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Http\Resources\Comment as CommentResource;

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

    public function index(BlogPost $post)
    {
        // dump(is_array($post->comments));
        // dump(get_class($post->comments));
        // die;
        return CommentResource::collection($post->comments()->with('user')->get());
        // return $post->comments()->with('user')->get();
    }
    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);
        event(new CommentPosted($comment));
        return redirect()->back()->with('success', 'Comment was created');
    }
}
