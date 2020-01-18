<?php

namespace App;

// use App\BlogPost;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use SebastianBergmann\CodeCoverage\Node\Builder;

class Comment extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['user_id', 'content'];

    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        //تسجيل النطاق العالمي في النوذج بعد إنشاء صف LatestScope
        //عبر تنفيذ الواجهة العالمية Scope
        // static::addGlobalScope(new LatestScope);


        //عند إضافة تعليق ينبغي حذف المنشور من الذاكرة المؤقتة
        static::creating(function(Comment $comment){
            //تنفيذ التعليمة على جميع المنشورات التي
            // تحتوي على وسم "منشور-مدونة" لكي يتم حذفها من الكاش
            
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->blog_post_id}");
            Cache::tags(['blog-post'])->forget('mostCommented');

        });

    }
}
