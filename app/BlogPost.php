<?php

namespace App;

// use App\Comment;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes;
    //    protected $table = 'blogposts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //تم استدعاء الاستعلام المحلي مباشرة على العلاقة
    //كيما يتم جلب المنشورات مرتبة حسب الزمن الجديد أولاً

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    //creating tags relationship
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        //comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }
   
    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
                     ->withCount('comments')
                     ->with('user')
                     ->with('tags');
    }

    //deleting model event
    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();

        // //تسجيل النطاق العالمي في النوذج بعد إنشاء صف LatestScope
        // //عبر تنفيذ الواجهة العالمية Scope

        static::deleting(function(BlogPost $blogPost){
            $blogPost->comments()->delete();
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");

        });

        static::updating(function(BlogPost $blogPost){
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });

        static::restoring(function (BlogPost $blogPost){
            $blogPost->comments()->restore();
        });
    }

   
}
