<?php

namespace App;

// use App\Comment;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes, Taggable;
    //    protected $table = 'blogposts';
    // protected $guarded = [];
    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //تم استدعاء الاستعلام المحلي مباشرة على العلاقة
    //كيما يتم جلب المنشورات مرتبة حسب الزمن الجديد أولاً

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
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
        
    }

   
}
