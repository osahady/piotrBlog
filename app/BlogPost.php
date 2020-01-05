<?php

namespace App;

// use App\Comment;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        //comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
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
        });

        static::restoring(function (BlogPost $blogPost){
            $blogPost->comments()->restore();
        });
    }

   
}
